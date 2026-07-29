<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UniversitasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Universitas::create([
            'nama_perguruan_tinggi' => 'Universitas Nurul Jadid',
            'sk_akreditasi' => 'Terakreditasi Baik Sekali oleh BAN-PT',
            'email' => 'unuja@unuja.ac.id',
            'no_telepon' => '08883077077',
        ]);
    }
}
