<?php

namespace Database\Seeders;

use App\Models\Kelurahan;
use Illuminate\Database\Seeder;

class KelurahanSeeder extends Seeder
{
    /**
     * Data kelurahan riil di wilayah Kecamatan Tanjung Selor, Kabupaten Bulungan.
     * Silakan sesuaikan/tambah jika sistem mencakup kecamatan lain.
     */
    public function run(): void
    {
        $kelurahan = [
            'Tanjung Selor Hilir',
            'Tanjung Selor Hulu',
            'Tanjung Selor Timur',
            'Jelarai Selor',
            'Bumi Rahayu',
            'Gunung Seriang',
            'Gunung Sari',
            'Apung',
            'Tengkapak',
        ];

        foreach ($kelurahan as $nama) {
            Kelurahan::firstOrCreate(['name' => $nama]);
        }
    }
}