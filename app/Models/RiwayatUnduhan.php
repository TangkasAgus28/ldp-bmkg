<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatUnduhan extends Model
{
    use HasFactory;

    protected $table = 'riwayat_unduhan';

    protected $fillable = [
        'dokumen_id',
        'user_id',
        'maskapai_id',
        'tanggal_unduh',
    ];

    protected $casts = [
        'tanggal_unduh' => 'datetime',
    ];

    // Relationship
    public function dokumen()
    {
        return $this->belongsTo(DokumenHarian::class, 'dokumen_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function maskapai()
    {
        return $this->belongsTo(Maskapai::class);
    }
}