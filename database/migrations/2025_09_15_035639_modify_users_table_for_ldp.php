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
    Schema::table('users', function (Blueprint $table) {
        // Tambah kolom baru
        $table->string('nama', 100)->after('id');
        $table->enum('role', ['forecaster', 'penerbangan'])->after('email');
        $table->foreignId('maskapai_id')->nullable()->after('role')->constrained('maskapai');
        
        // Hapus kolom yang tidak dibutuhkan
        $table->dropColumn('name');
        $table->dropColumn('email_verified_at');
        $table->dropColumn('remember_token');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        // Kembalikan kolom yang dihapus
        $table->string('name')->after('id');
        $table->timestamp('email_verified_at')->nullable()->after('email');
        $table->rememberToken();
        
        // Hapus kolom yang ditambah
        $table->dropForeign(['maskapai_id']);
        $table->dropColumn(['nama', 'role', 'maskapai_id']);
    });
}
};
