<?php

namespace App\Filament\Pages;

use App\Models\Aset;
use App\Models\StokOpname;
use App\Models\StokOpnameAsetLog;
use Filament\Pages\Page;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

// Livewire upload
use Livewire\WithFileUploads;

// QR decoder lib (khanamiryan/qrcode-detector-decoder)
use Zxing\QrReader;

class StockOpnamePage extends Page
{
    use WithFileUploads;

    // --- Sidebar / Menu (sudah sesuai panelmu) ---
    protected static ?string $navigationLabel = 'Stock Opname';
    protected static ?string $navigationGroup = 'Transaksi';
    protected static ?string $navigationIcon  = 'heroicon-o-qr-code';

    // URL halaman, kamu buka di /admin/stock-opname-page
    protected static ?string $slug = 'stock-opname-page';

    // Judul halaman
    protected static ?string $title = '';

    // Blade view yg dipakai
    protected static string $view = 'filament.pages.stock-opname-page';

    // ====== STATE (Livewire public props) ======
    public $kodeAset = '';       // input barcode / id yang di-scan / hasil decode QR
    public $foundAset = null;    // array hasil scan yg ditampilkan di tabel
    public $foundAsetId = null;  // ID aset di DB
    public $statusBaru = 'OK';   // dropdown status baru
    public $catatan = '';        // catatan opsional (walau di UI sekarang udah ga ditampilkan)

    // === File upload untuk fitur "Unggah QR Code" ===
    public $qrFile;              // Livewire temporary file (jpg/png)

    /**
     * Dipanggil saat klik tombol "Scan Barcode"
     * atau setelah berhasil decode QR dari file upload.
     */
    public function cariAset()
    {
        $rawKode = trim($this->kodeAset);

        // 1. cari berdasarkan kode_scan (kode 9 digit yang ditempel sebagai QR)
        $aset = Aset::where('kode_scan', $rawKode)->first();

        // 2. fallback: cari by id biasa (buat testing manual / legacy)
        if (! $aset) {
            $aset = Aset::where('id', $rawKode)->first();
        }

        if (! $aset) {
            // kalau nggak ketemu: kosongkan hasil & kasih popup merah
            $this->resetScanResult();

            Notification::make()
                ->title('Aset tidak ditemukan')
                ->body("Kode / barcode {$this->kodeAset} tidak ada di database.")
                ->danger()
                ->send();

            return;
        }

        // kalau ketemu, simpan data aset dalam bentuk ARRAY AMAN buat Livewire
        $this->foundAsetId = $aset->getKey();
        $this->foundAset = [
            'nama_aset'   => $aset->nama_aset ?? $aset->nama ?? '',
            'merk'        => $aset->merk_kode ?? $aset->merk ?? '',
            'status_now'  => $aset->status ?? '',
            'barcode'     => $aset->kode_scan ?? $rawKode, // tampilkan kode_scan 9 digit
            'qty'         => 1,
        ];

        // set dropdown statusBaru default ke status sekarang
        $this->statusBaru = $aset->status ?? 'OK';

        // reset catatan untuk aset ini
        $this->catatan    = '';

        // popup hijau info ketemu
        Notification::make()
            ->title('Aset ditemukan')
            ->body('Data aset berhasil dimuat ke tabel.')
            ->success()
            ->send();
    }

    /**
     * Dipanggil saat klik "Update Status"
     */
    public function simpanOpname()
    {
        // Safety: pastikan kita punya aset yg sedang aktif
        if (! $this->foundAsetId) {
            Notification::make()
                ->title('Tidak ada aset yang aktif')
                ->body('Scan aset terlebih dahulu sebelum update status.')
                ->danger()
                ->send();
            return;
        }

        // Ambil aset dari DB
        $aset = Aset::find($this->foundAsetId);

        if (! $aset) {
            Notification::make()
                ->title('Aset tidak ditemukan')
                ->body('Data aset tidak valid / mungkin sudah dihapus.')
                ->danger()
                ->send();
            return;
        }

        // Simpan log opname kondisi aset KE TABEL LOG
        StokOpnameAsetLog::create([
            'aset_id'      => $aset->id,
            'status_fisik' => $this->statusBaru ?? $aset->status,
            'catatan'      => $this->catatan, // walau catatan tersembunyi di UI, kita keep di backend
            'checked_at'   => now(),
            'checked_by'   => Auth::id(), // boleh null kalau tidak pakai auth user
        ]);

        // Update status aset di tabel asets (mutasi kondisi real-time)
        $aset->status = $this->statusBaru ?? $aset->status;
        $aset->save();

        // Kirim notif sukses
        Notification::make()
            ->title('Status diperbarui')
            ->body('Opname berhasil disimpan dan status aset diperbarui.')
            ->success()
            ->send();

        // Bersihkan catatan input
        $this->catatan = '';

        // Refresh status lama yg ditampilkan di tabel hasil scan
        $this->foundAset['status_now'] = $aset->status;
    }

    /**
     * Reset hasil scan di tabel (dipakai kalau aset tidak ditemukan)
     */
    protected function resetScanResult()
    {
        $this->foundAset   = null;
        $this->foundAsetId = null;
        $this->statusBaru  = 'OK';
        $this->catatan     = '';
    }

    /**
     * Livewire otomatis manggil ini begitu $qrFile berubah
     * (artinya user habis pilih file lewat "Unggah QR Code").
     *
     * Di sini kita decode QR dari gambar dan langsung panggil cariAset().
     */
    public function updatedQrFile()
    {
        if (! $this->qrFile) {
            return;
        }
        // path sementara file upload
        $tmpPath = $this->qrFile->getRealPath();
        $ext = strtolower($this->qrFile->getClientOriginalExtension() ?? '');

        // hanya support gambar. kalau PDF, tolak (karena kita udah buang Imagick).
        if ($ext === 'pdf') {
            Notification::make()
                ->title('PDF belum didukung')
                ->body('Silakan unggah gambar (jpg/png) berisi QR Code.')
                ->danger()
                ->send();
            return;
        }

        // coba decode QR dari gambar
        $decodedText = $this->decodeQrFromImage($tmpPath);

        if (! $decodedText) {
            Notification::make()
                ->title('Gagal membaca QR')
                ->body('Pastikan foto jelas dan QR Code tidak blur.')
                ->danger()
                ->send();
            return;
        }

        // taruh isi QR ke input utama
        $this->kodeAset = trim($decodedText);

        // jalankan logika pencarian aset supaya tabel hasil muncul
        $this->cariAset();
    }

    public function refreshOpname(): void
    {
    // kosongkan semua state halaman
    $this->reset([
        'kodeAset',
        'foundAset',
        'foundAsetId',
        'statusBaru',
        'catatan',
        'qrFile',
    ]);
    
    // optional: bersihkan error/validasi kalau ada
    $this->resetErrorBag();
    $this->resetValidation();
    }


    // untuk kontrol modal kamera (Livewire <-> Blade/Alpine)
    public $showCameraModal = false;

    // biar Livewire bisa nerima event JS -> Livewire.emit('kode-dari-kamera', '012345678')
    protected $listeners = [
        'kode-dari-kamera' => 'handleCameraScan',
    ];

    /**
     * Dipanggil dari tombol "Scan Kamera"
     * -> ini cuma nyalain modal kamera
     */
    public function bukaKamera(): void
    {
        $this->showCameraModal = true;
    }

    /**
     * Dipanggil saat user nutup modal kamera secara manual
     */
    public function tutupKamera(): void
    {
        $this->showCameraModal = false;
    }

    /**
     * Dipanggil dari JS ketika QR berhasil terbaca dari kamera.
     * $kode akan berisi string QR (misal kode_scan asset).
     */
    public function handleCameraScan($kode): void
    {
        // isi input kodeAset dengan hasil kamera
        $this->kodeAset = trim($kode ?? '');

        // tutup modal kamera
        $this->showCameraModal = false;

        // jalankan flow biasa seperti klik "Scan Barcode"
        $this->cariAset();
    }


    /**
     * Decode QR dari file gambar (jpg/png/webp/etc).
     * Memakai library khanamiryan/qrcode-detector-decoder (Zxing\QrReader).
     */
    protected function decodeQrFromImage(string $path): ?string
    {
        try {
            $qrcode = new QrReader($path);
            $text = $qrcode->text();
            if (is_string($text) && trim($text) !== '') {
                return trim($text);
            }
        } catch (\Throwable $e) {
            // Kalau gagal decode, balikin null saja.
        }
        return null;
    }
}
