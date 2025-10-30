<x-filament::page>
    <div class="max-w-5xl mx-auto w-full">

        {{-- Judul halaman --}}
        <h1 class="text-xl font-semibold text-gray-800 mb-4">
            Stock Opname
        </h1>

        {{-- CARD UTAMA --}}
        <div class="bg-white border border-gray-300 rounded-md shadow-sm">
            {{-- Header kecil di dalam card --}}
            <div class="px-4 py-3 border-b border-gray-200">
                <h2 class="text-sm font-semibold text-gray-800">
                    Stock Opname
                </h2>
            </div>

            {{-- Bagian input scan --}}
            <div class="px-4 py-4 space-y-4">
                <div class="flex flex-col md:flex-row md:items-start md:gap-3">
                    {{-- input kode --}}
                    <div class="flex-1">
                        <input
                            type="text"
                            wire:model.defer="kodeAset"
                            class="block w-full rounded border border-gray-300 px-3 py-2 text-sm focus:border-primary-500 focus:ring-primary-500"
                            placeholder="Tempel / scan kode aset di sini"
                        >
                    </div>

                    {{-- tombol Scan Barcode & Unggah QR --}}
                    <div class="mt-3 md:mt-0 flex-shrink-0 flex gap-2">
                    {{-- Tombol Scan Barcode / Cari --}}
                    <x-filament::button
                        wire:click="cariAset"
                        color="primary"
                        icon="heroicon-o-qr-code"
                    >
                        Check QR Code
                    </x-filament::button>

                    {{-- Upload QR: input file hidden + tombol hijau --}}
                    <div x-data>
                        {{-- input file tersembunyi --}}
                        <input
                            x-ref="qrInput"
                            id="qrUpload"
                            type="file"
                            accept="image/*,application/pdf"
                            class="hidden"
                            wire:model="qrFile"
                        />

                        {{-- tombol hijau pakai style bawaan Filament --}}
                        <x-filament::button
                            color="success"
                            icon="heroicon-o-arrow-up-tray"
                            x-on:click="$refs.qrInput.click()"
                        >
                            Unggah QR Code
                        </x-filament::button>
                    </div>
                </div>
                </div>
                
                {{-- Tombol Scan Kamera (buka modal kamera)
                <div class="flex justify-center">
                    <x-filament::button
                        color="primary"
                        icon="heroicon-o-camera"
                        wire:click="bukaKamera"
                    >
                        Scan Kamera
                    </x-filament::button>
                </div> --}}

                {{-- Tombol kembali --}}
                <div class="flex justify-center">
                    {{-- Tombol Refresh (ganti "Kembali") --}}
                    <x-filament::button
                        color="gray"
                        icon="heroicon-o-arrow-path"
                        wire:click="refreshOpname"
                    >
                        Refresh
                    </x-filament::button>
                </div>
            </div>

            {{-- Hasil Scan --}}
            <div class="px-4 pb-4">
                <div class="border border-gray-200 rounded-md overflow-hidden">
                    {{-- Header Hasil Scan --}}
                    <div class="px-4 py-2 border-b border-gray-200 bg-gray-50 text-center text-sm font-semibold text-gray-700">
                        Hasil Scan:
                    </div>

                    {{-- Table --}}
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm text-gray-800">
                            <thead class="bg-gray-100 border-b border-gray-200 text-xs text-gray-600 uppercase">
                                <tr>
                                    <th class="px-4 py-2 text-left font-medium">Nama Aset</th>
                                    <th class="px-4 py-2 text-left font-medium">Merk</th>
                                    <th class="px-4 py-2 text-left font-medium">Status</th>
                                    <th class="px-4 py-2 text-left font-medium">Qty</th>
                                    <th class="px-4 py-2 text-left font-medium">Barcode</th>
                                    <th class="px-4 py-2 text-left font-medium">Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                @if ($foundAset)
                                    <tr class="border-b border-gray-200">
                                        {{-- Nama Aset --}}
                                        <td class="px-4 py-3 align-top">
                                            <div class="text-gray-900">
                                                {{ $foundAset['nama_aset'] ?? '-' }}
                                            </div>
                                        </td>

                                        {{-- Merk --}}
                                        <td class="px-4 py-3 align-top">
                                            <div class="text-gray-700">
                                                {{ $foundAset['merk'] ?? '-' }}
                                            </div>
                                        </td>

                                        {{-- Status (Dropdown Status Baru + status lama + catatan) --}}
                                        <td class="px-4 py-3 align-top">
                                            <div class="flex flex-col gap-2 w-[110px]">

                                                {{-- dropdown pilih status baru --}}
                                                <select
                                                    wire:model.defer="statusBaru"
                                                    class="block w-full rounded border border-gray-300 text-sm px-2 py-1.5 focus:border-primary-500 focus:ring-primary-500"
                                                >
                                                    <option value="OK">OK</option>
                                                    <option value="Rusak">Rusak</option>
                                                    <option value="Hilang">Hilang</option>
                                                    <option value="Dipinjam">Dipinjam</option>
                                                </select>

                                                {{-- status lama (info) --}}
                                                <div class="text-[11px] text-gray-500 leading-tight">
                                                    Kondisi lama:
                                                    <span class="font-medium text-gray-700">
                                                        {{ $foundAset['status_now'] ?? '-' }}
                                                    </span>
                                                </div>

                                                {{-- catatan
                                                <textarea
                                                    wire:model.defer="catatan"
                                                    rows="2"
                                                    class="block w-full rounded border border-gray-300 text-[11px] leading-snug px-2 py-1 focus:border-primary-500 focus:ring-primary-500 resize-none"
                                                    placeholder="Catatan (opsional)"
                                                ></textarea>
                                            </div>
                                        </td> --}}

                                        {{-- Qty --}}
                                        <td class="px-4 py-3 align-top text-gray-700">
                                            {{ $foundAset['qty'] ?? 1 }}
                                        </td>

                                        {{-- Barcode --}}
                                        <td class="px-4 py-3 align-top text-gray-700 font-mono text-xs select-all">
                                            {{ $foundAset['barcode'] ?? '-' }}
                                        </td>

                                        {{-- Aksi --}}
                                        <td class="px-4 py-3 align-top">
                                            <x-filament::button
                                                wire:click="simpanOpname"
                                                color="warning"
                                                size="sm"
                                            >
                                                Update Status
                                            </x-filament::button>
                                        </td>
                                    </tr>
                                @else
                                    {{-- Kalau belum ada hasil scan --}}
                                    <tr>
                                        <td colspan="6" class="px-4 py-6 text-center text-gray-400 text-sm">
                                            Belum ada hasil scan.
                                            Silakan scan / cari barcode aset.
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div> {{-- end table card --}}
            </div> {{-- end px --}}
        </div> {{-- end outer card --}}
    </div> {{-- max-w --}}

        {{-- === MODAL KAMERA QR === --}}
    <div
        x-data="qrScannerComponent()"
        x-show="@js($showCameraModal)"
        x-cloak
        class="fixed inset-0 z-[2000] flex items-center justify-center bg-black/60"
        x-init="
            $watch(
                () => @js($showCameraModal),
                value => {
                    if (value) {
                        startCamera();
                    } else {
                        stopCamera();
                    }
                }
            );
        "
    >
        <div class="bg-white rounded-lg shadow-lg w-full max-w-sm p-4 relative">

            {{-- Tombol close --}}
            <button
                class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-xs border border-gray-300 rounded px-2 py-1"
                wire:click="tutupKamera"
                x-on:click="stopCamera()"
            >
                Tutup
            </button>

            <h2 class="text-sm font-semibold text-gray-800 mb-3">
                Arahkan QR Aset ke Kamera
            </h2>

            <div class="w-full bg-black rounded overflow-hidden flex items-center justify-center">
                <video
                    x-ref="videoEl"
                    class="w-full h-auto"
                    playsinline
                    muted
                ></video>
            </div>

            <p class="text-[11px] text-gray-500 mt-2 leading-tight">
                Kami akan mencoba membaca QR secara otomatis.
            </p>

        </div>
    </div>

        {{-- JS helper untuk scan QR dari kamera --}}
    <script src="https://cdn.jsdelivr.net/npm/jsqr@1.4.0/dist/jsQR.js"></script>

    <script>
        function qrScannerComponent() {
            return {
                videoStream: null,
                scanning: false,
                videoEl: null,
                canvasEl: null,
                ctx: null,

                startCamera() {
                    if (this.scanning) return;

                    this.videoEl = this.$refs.videoEl;

                    // siapkan canvas off-screen untuk baca frame
                    this.canvasEl = document.createElement('canvas');
                    this.ctx = this.canvasEl.getContext('2d');

                    navigator.mediaDevices.getUserMedia({
                        video: { facingMode: 'environment' }
                    })
                    .then(stream => {
                        this.videoStream = stream;
                        this.videoEl.srcObject = stream;
                        this.videoEl.play();
                        this.scanning = true;
                        this.tick(); // mulai loop scan
                    })
                    .catch(err => {
                        console.error('Gagal akses kamera', err);
                        this.scanning = false;
                        // fallback: berhentiin modal
                        Livewire.dispatch('tutupKamera'); // panggil method tutupKamera()
                    });
                },

                stopCamera() {
                    this.scanning = false;
                    if (this.videoStream) {
                        this.videoStream.getTracks().forEach(t => t.stop());
                        this.videoStream = null;
                    }
                },

                tick() {
                    if (!this.scanning) return;

                    if (this.videoEl.readyState === this.videoEl.HAVE_ENOUGH_DATA) {
                        // set ukuran canvas == frame video
                        this.canvasEl.width  = this.videoEl.videoWidth;
                        this.canvasEl.height = this.videoEl.videoHeight;
                        this.ctx.drawImage(
                            this.videoEl,
                            0,
                            0,
                            this.canvasEl.width,
                            this.canvasEl.height
                        );

                        const imageData = this.ctx.getImageData(
                            0,
                            0,
                            this.canvasEl.width,
                            this.canvasEl.height
                        );

                        const qrResult = jsQR(imageData.data,
                            imageData.width,
                            imageData.height,
                            { inversionAttempts: "dontInvert" }
                        );

                        if (qrResult && qrResult.data) {
                            // QR ketemu!
                            const kode = qrResult.data.trim();

                            // stop kamera
                            this.stopCamera();

                            // kirim hasil QR ke Livewire
                            Livewire.dispatch('kode-dari-kamera', {0: kode});

                            return; // jangan lanjut loop
                        }
                    }

                    // lanjut loop tiap ~150ms
                    setTimeout(() => this.tick(), 150);
                },
            }
        }
    </script>

</x-filament::page>
