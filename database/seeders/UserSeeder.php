<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Maskapai;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // User Forecaster (Tim BMKG)
        User::create([
            'nama' => 'Ahmad Prasetyo',
            'email' => 'forecaster@bmkg.go.id',
            'password' => Hash::make('password123'),
            'role' => 'forecaster',
            'maskapai_id' => null
        ]);

        // User Penerbangan - Garuda Indonesia
        $garuda = Maskapai::where('kode', 'GA')->first();
        User::create([
            'nama' => 'Sari Dewi',
            'email' => 'sari@garuda-indonesia.com',
            'password' => Hash::make('password123'),
            'role' => 'penerbangan',
            'maskapai_id' => $garuda->id
        ]);

        // User Penerbangan - Lion Air
        $lion = Maskapai::where('kode', 'JT')->first();
        User::create([
            'nama' => 'Budi Santoso',
            'email' => 'budi@lionair.co.id',
            'password' => Hash::make('password123'),
            'role' => 'penerbangan',
            'maskapai_id' => $lion->id
        ]);

        // User Penerbangan - AirAsia
        $airasia = Maskapai::where('kode', 'QZ')->first();
        User::create([
            'nama' => 'Maya Sari',
            'email' => 'maya@airasia.com',
            'password' => Hash::make('password123'),
            'role' => 'penerbangan',
            'maskapai_id' => $airasia->id
        ]);
    }
}