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
    Schema::create('dokumen_harian', function (Blueprint $table) {
        $table->id();
        $table->string('judul', 150);
        $table->text('deskripsi');
        $table->string('file_path', 255); // path/URL file
        $table->date('tanggal_upload');
        $table->foreignId('forecaster_id')->constrained('users')->notNull();
        $table->timestamps();
        
        $table->index(['forecaster_id']);
        $table->index(['tanggal_upload']);
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumen_harian');
    }
};
