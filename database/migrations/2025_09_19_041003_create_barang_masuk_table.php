<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('barang_masuk', function (Blueprint $table) {
            $table->id();

            // No Transaksi unik
            $table->string('no_transaksi')->unique();

            // Relasi ke tabel barangs
            $table->foreignId('barang_id')
                  ->constrained('barangs')
                  ->cascadeOnDelete();

            // ✅ kategori manual (string)
            $table->string('kategori');

            // Relasi ke tabel users
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->cascadeOnDelete();

            // Jumlah barang masuk
            $table->integer('jumlah');

            // Default tanggal hari ini
            $table->date('tanggal')->default(DB::raw('CURRENT_DATE'));

            $table->timestamps();

            // Pastikan pakai InnoDB biar FK jalan
            $table->engine = 'InnoDB';
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('barang_masuk');
    }
};
