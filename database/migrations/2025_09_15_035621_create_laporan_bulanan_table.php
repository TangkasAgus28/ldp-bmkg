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
    Schema::create('laporan_bulanan', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained('users')->notNull(); // forecaster/penerbangan
        $table->integer('bulan'); // 1-12
        $table->integer('tahun');
        $table->integer('total'); // total unggahan (forecaster) / total unduhan (penerbangan)
        $table->enum('jenis_laporan', ['unggahan', 'unduhan']); // 'unggahan' atau 'unduhan'
        $table->timestamps();
        
        $table->unique(['user_id', 'tahun', 'bulan', 'jenis_laporan']);
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_bulanan');
    }
};
