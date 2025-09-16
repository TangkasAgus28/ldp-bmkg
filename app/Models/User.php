<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nama',
        'email',
        'password',
        'role',
        'maskapai_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    // Relationship
    public function maskapai()
    {
        return $this->belongsTo(Maskapai::class);
    }

    public function dokumenHarian()
    {
        return $this->hasMany(DokumenHarian::class, 'forecaster_id');
    }

    public function riwayatUnduhan()
    {
        return $this->hasMany(RiwayatUnduhan::class);
    }

    public function laporanBulanan()
    {
        return $this->hasMany(LaporanBulanan::class);
    }
}