<?php

namespace Database\Seeders;

use App\Models\Kontak;
use Illuminate\Database\Seeder;

class KontakSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Kontak::create([
            'alamat' => 'Jl. Raya Ngurah Rai, Tuban, Kabupaten Badung, Bali 80362',
            'telepon' => '(0361) 751038',
            'email' => 'bmkg.ngurahrai@bmkg.go.id'
        ]);
    }
}