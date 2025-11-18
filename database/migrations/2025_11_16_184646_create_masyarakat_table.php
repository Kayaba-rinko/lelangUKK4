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
        Schema::create('masyarakat', function (Blueprint $table) {
            $table->id('id_masyarakat');
            $table->string('name');
            $table->string('username')->unique();
            $table->string('telp')->nullable()->unique();
            $table->string('password');
            $table->text('alamat')->nullable();
            $table->enum('status', ['aktif', 'blokir'])->default('aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('masyarakat');
    }
};
