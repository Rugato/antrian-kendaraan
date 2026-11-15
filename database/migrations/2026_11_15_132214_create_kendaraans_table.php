<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Membuat tabel 'kendaraans' yang berelasi dengan tabel 'users' (One-to-Many).
     */
    public function up(): void
    {
        Schema::create('kendaraans', function (Blueprint $table) {
            $table->id();
            // Foreign key ke tabel users untuk mencatat petugas/admin yang menginput data
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('nomor_polisi', 20)->unique();
            $table->string('jenis_kendaraan', 50); // Contoh: Motor, Mobil, Truk
            $table->string('nama_pemilik', 100);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kendaraans');
    }
};