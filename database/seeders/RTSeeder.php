<?php

namespace Database\Seeders;

use App\Models\Kelurahan;
use App\Models\RT;
use Illuminate\Database\Seeder;

class RTSeeder extends Seeder
{
    /**
     * Setiap kelurahan diberi 3-6 RT dengan format "RT 001", "RT 002", dst.
     */
    public function run(): void
    {
        Kelurahan::all()->each(function (Kelurahan $kelurahan) {
            $jumlahRt = rand(3, 6);

            for ($i = 1; $i <= $jumlahRt; $i++) {
                RT::firstOrCreate([
                    'name' => 'RT ' . str_pad($i, 3, '0', STR_PAD_LEFT),
                    'id_kelurahan' => $kelurahan->id,
                ]);
            }
        });
    }
}