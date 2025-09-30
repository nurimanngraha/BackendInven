<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stok_opname', function (Blueprint $table) {
            $table->id();

            // Relasi ke barangs
            $table->foreignId('barang_id')
                  ->constrained('barangs')
                  ->cascadeOnDelete();

            // Stok sistem default 0
            $table->integer('stok_sistem')->default(0);

            // Stok fisik yang dicek saat opname
            $table->integer('stok_fisik');

            // Tanggal opname (boleh kosong)
            $table->date('tanggal')->nullable();

            $table->timestamps();

            // Engine database
            $table->engine = 'InnoDB';
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stok_opname');
    }
};
