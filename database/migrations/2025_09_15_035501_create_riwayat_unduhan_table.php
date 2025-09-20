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
    Schema::create('riwayat_unduhan', function (Blueprint $table) {
        $table->id();
        $table->foreignId('dokumen_id')->constrained('dokumen_harian')->notNull();
        $table->foreignId('user_id')->constrained('users')->notNull(); // user role = penerbangan
        $table->foreignId('maskapai_id')->constrained('maskapai')->notNull(); // redundansi terkontrol utk filter cepat per maskapai
        $table->dateTime('tanggal_unduh')->notNull();
        $table->timestamps(); // TAMBAHKAN INI
        
        $table->index(['dokumen_id']);
        $table->index(['user_id']);
        $table->index(['maskapai_id']);
        $table->unique(['dokumen_id', 'user_id']); // catat sekali per user per dokumen
        $table->index(['maskapai_id', 'tanggal_unduh']);
        $table->index(['user_id', 'tanggal_unduh']);
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_unduhan');
    }
};
