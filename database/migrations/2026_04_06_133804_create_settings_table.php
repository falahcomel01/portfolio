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
        // TARUH KODE KAMU DI SINI
        Schema::table('settings', function (Blueprint $table) {
            $table->string('role')->default('Frontend Developer')->after('title');
            $table->string('passion')->default('Beautiful Code')->after('role');
            $table->string('wa_message')->default('Halo!')->after('whatsapp');
            $table->string('hero_badge')->default('Available for work')->after('hero_desc');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Opsional: Logika untuk menghapus kolom jika rollback dilakukan
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn(['role', 'passion', 'wa_message']);
        });
    }
};