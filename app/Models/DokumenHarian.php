<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumenHarian extends Model
{
    use HasFactory;

    protected $table = 'dokumen_harian';

    protected $fillable = [
        'judul',
        'deskripsi',
        'file_path',
        'tanggal_upload',
        'forecaster_id',
    ];

    protected $casts = [
        'tanggal_upload' => 'date',
    ];

    // Relationship
    public function forecaster()
    {
        return $this->belongsTo(User::class, 'forecaster_id');
    }

    public function riwayatUnduhan()
    {
        return $this->hasMany(RiwayatUnduhan::class, 'dokumen_id');
    }
}