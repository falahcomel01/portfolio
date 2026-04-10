<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Nama Sertifikat
            $table->string('issuer'); // Penerbit (misal: Dicoding, Google)
            $table->date('issued_date'); // Tanggal terbit
            $table->string('image'); // Nama file gambar
            $table->string('url')->nullable(); // Link verifikasi (opsional)
            $table->integer('sort_order')->default(0); // Untuk mengurutkan
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};