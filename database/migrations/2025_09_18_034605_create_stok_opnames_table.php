<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stok_opnames', function (Blueprint $table) {
            $table->id();

            // nama atau deskripsi barang langsung
            $table->string('nama_barang');

            // barcode opsional
            $table->string('barcode')->nullable()->unique();

            // stok sistem dan stok fisik
            $table->integer('stok_sistem')->default(0);
            $table->integer('stok_fisik')->default(0);

            // selisih stok = stok_fisik - stok_sistem
            $table->integer('selisih')->default(0);

            // status kondisi barang
            $table->enum('status', ['ok', 'rusak'])->default('ok');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stok_opnames');
    }
};
