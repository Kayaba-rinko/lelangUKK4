<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('lelangs', function (Blueprint $table) {
            $table->id('id_lelang');
            $table->foreignId('id_barang')->references('id_barang')->on('barangs')->onDelete('cascade');
            $table->foreignId('id_petugas')->references('id_petugas')->on('petugas')->onDelete('cascade');
            $table->dateTime('tgl_lelang')->nullable();
            $table->dateTime('tanggal_akhir')->nullable();
            $table->double('harga_awal')->nullable();
            $table->double('harga_akhir')->nullable();
            $table->foreignId('id_masyarakat')->nullable()->references('id_masyarakat')->on('masyarakat')->onDelete('cascade');
            $table->enum('status', ['dibuka', 'ditutup'])->default('dibuka');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lelangs');
    }
};
