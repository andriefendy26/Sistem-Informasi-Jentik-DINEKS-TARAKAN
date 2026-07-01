<?php

namespace Database\Seeders;

use App\Models\Kelurahan;
use App\Models\RT;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan role dasar tersedia (butuh package filament-shield / spatie/permission)
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $petugasRole = Role::firstOrCreate(['name' => 'petugas', 'guard_name' => 'web']);

        $kelurahanPertama = Kelurahan::first();
        $rtPertama = RT::where('id_kelurahan', $kelurahanPertama->id)->first();

        // 1 akun Super Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@abj.test'],
            [
                'name' => 'Administrator',
                'username' => 'admin',
                'password' => Hash::make('password'),
                'id_kelurahan' => $kelurahanPertama->id,
                'id_rt' => $rtPertama->id,
            ]
        );
        $admin->assignRole($adminRole);

        // 1 akun petugas untuk tiap RT di setiap kelurahan
        Kelurahan::with('RT')->get()->each(function (Kelurahan $kelurahan) use ($petugasRole) {
            $kelurahan->RT->each(function (RT $rt) use ($kelurahan, $petugasRole) {
                $slug = str($kelurahan->name . '-' . $rt->name)->slug('-');

                $user = User::firstOrCreate(
                    ['username' => 'petugas-' . $slug],
                    [
                        'name' => 'Petugas ' . $kelurahan->name . ' ' . $rt->name,
                        'email' => 'petugas.' . $slug . '@abj.test',
                        'password' => Hash::make('password'),
                        'id_kelurahan' => $kelurahan->id,
                        'id_rt' => $rt->id,
                    ]
                );
                $user->assignRole($petugasRole);
            });
        });
    }
}