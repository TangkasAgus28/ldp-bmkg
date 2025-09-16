<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanBulanan extends Model
{
    use HasFactory;

    protected $table = 'laporan_bulanan';

    protected $fillable = [
        'user_id',
        'bulan',
        'tahun',
        'total',
        'jenis_laporan',
    ];

    // Relationship
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}