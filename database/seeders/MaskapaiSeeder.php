<?php

namespace Database\Seeders;

use App\Models\Maskapai;
use Illuminate\Database\Seeder;

class MaskapaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $maskapai = [
            [
                'nama' => 'Garuda Indonesia',
                'kode' => 'GA'
            ],
            [
                'nama' => 'Lion Air',
                'kode' => 'JT'
            ],
            [
                'nama' => 'Sriwijaya Air',
                'kode' => 'SJ'
            ],
            [
                'nama' => 'Indonesia AirAsia',
                'kode' => 'QZ'
            ],
            [
                'nama' => 'Citilink',
                'kode' => 'QG'
            ],
            [
                'nama' => 'Batik Air',
                'kode' => 'ID'
            ]
        ];

        foreach ($maskapai as $data) {
            Maskapai::create($data);
        }
    }
}