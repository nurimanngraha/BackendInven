<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\StokOpname;

class StokOpnameMultiScan extends Component
{
    public $barcode = '';
    public $scanResults = [];

    protected $rules = [
        'barcode' => 'required|string',
    ];

    /**
     * Scan barcode dan tambah ke array hasil scan
     */
    public function scanBarcode()
    {
        $this->validate();

        $stok = StokOpname::with('aset')
            ->where('barcode', $this->barcode)
            ->first();

        if (!$stok) {
            session()->flash('error', "Barcode '{$this->barcode}' tidak ditemukan!");
            return;
        }

        // Cek jika sudah di-scan
        if (!collect($this->scanResults)->contains('id', $stok->id)) {
            $this->scanResults[] = $stok;
        }

        $this->barcode = ''; // reset input
    }

    /**
     * Update status atau stok fisik
     */
    public function updateStok($id, $stokFisik = null, $status = null)
    {
        $stok = StokOpname::find($id);
        if ($stok) {
            if ($stokFisik !== null) {
                $stok->stok_fisik = $stokFisik;
            }
            if ($status !== null) {
                $stok->status = $status;
            }
            $stok->save();
            session()->flash('success', "Stok '{$stok->aset->nama}' berhasil diupdate!");
            // refresh scanResults
            $this->scanResults = array_map(function($item) use ($stok) {
                return $item->id === $stok->id ? $stok->fresh('aset') : $item;
            }, $this->scanResults);
        }
    }

    public function render()
    {
        return view('livewire.stok-opname-multi-scan');
    }
}
