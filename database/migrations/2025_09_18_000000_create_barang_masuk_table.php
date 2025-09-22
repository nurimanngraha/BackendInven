<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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

            // Relasi ke tabel kategoris
            $table->foreignId('kategori_id')
                  ->constrained('kategoris')
                  ->cascadeOnDelete();

            // Relasi ke tabel users
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->cascadeOnDelete();

            // Jumlah barang masuk
            $table->integer('jumlah');

            // Default tanggal hari ini (lebih aman pakai nullable + default set via model)
            $table->date('tanggal')->nullable();

            $table->timestamps();

            // Pastikan engine InnoDB
            $table->engine = 'InnoDB';
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('barang_masuk');
    }
};
