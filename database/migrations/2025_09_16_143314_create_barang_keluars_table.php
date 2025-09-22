<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('barang_keluars', function (Blueprint $table) {
            $table->id();

            // Nomor transaksi unik
            $table->string('no_transaksi', 50)->unique();

            // Relasi ke tabel barangs
            $table->foreignId('barang_id')
                  ->constrained('barangs')
                  ->cascadeOnDelete();

            // Tanggal keluar default hari ini
            $table->date('tanggal_keluar')
                  ->default(DB::raw('CURRENT_DATE'));

            // Jumlah barang keluar
            $table->integer('jumlah');

            // Informasi penerima & tambahan
            $table->string('penerima', 255);
            $table->string('bagian', 255)->nullable();
            $table->string('petugas', 255)->nullable();

            $table->timestamps();

            $table->engine = 'InnoDB';
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('barang_keluars');
    }
};
