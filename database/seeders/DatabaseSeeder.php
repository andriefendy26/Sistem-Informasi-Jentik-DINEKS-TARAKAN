<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // urutan penting: Kelurahan -> RT -> User -> ABJ (mengikuti relasi foreign key)
        $this->call([
            // KelurahanSeeder::class,
            // RTSeeder::class,
            // UserSeeder::class,
            AbjSeeder::class,
        ]);
    }
}