<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maskapai extends Model
{
    use HasFactory;

    protected $table = 'maskapai';

    protected $fillable = [
        'nama',
        'kode',
    ];

    // Relationship
    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function riwayatUnduhan()
    {
        return $this->hasMany(RiwayatUnduhan::class);
    }
}