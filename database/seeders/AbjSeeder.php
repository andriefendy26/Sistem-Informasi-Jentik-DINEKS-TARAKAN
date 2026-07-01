<?php

namespace Database\Seeders;

use App\Models\abj;
use App\Models\RT;
use App\Models\User;
use Illuminate\Database\Seeder;

class AbjSeeder extends Seeder
{
    /**
     * Simulasikan hasil pemeriksaan jentik per RT selama beberapa bulan terakhir.
     * Aturan mengikuti PRD:
     * - rumah_berjentik      = 1 jika penampungan_berjentik > 0
     * - rumah_tidak_berjentik = 1 jika penampungan_berjentik = 0
     */
    public function run(): void
    {
        $namaKepalaKeluarga = [
            'Ahmad Suryadi', 'Budi Hartono', 'Siti Aminah', 'Andi Wijaya',
            'Muhammad Yusuf', 'Rina Marlina', 'Joko Prasetyo', 'Dewi Lestari',
            'Herman Santoso', 'Nur Hidayah', 'Agus Setiawan', 'Yuliana Putri',
            'Sutrisno', 'Fatimah Zahra', 'Wahyu Nugroho', 'Rahmawati',
            'Eko Purnomo', 'Indah Sari', 'Bambang Irawan', 'Maya Sari',
        ];

        // periksa 5 bulan terakhir agar data dashboard "per bulan" ada variasinya
        $bulanPemeriksaan = collect(range(0, 4))->map(
            fn ($i) => now()->subMonths($i)->startOfMonth()
        );

        // ambil semua user yang ada (RT/Kelurahan diisi manual, jadi tidak wajib 1 user per RT)
        $users = User::all();

        if ($users->isEmpty()) {
            $this->command->warn('AbjSeeder dilewati: belum ada data user sama sekali. Buat minimal 1 user dulu.');
            return;
        }

        RT::with('Kelurahan')->get()->each(function (RT $rt) use ($namaKepalaKeluarga, $bulanPemeriksaan, $users) {
            foreach ($bulanPemeriksaan as $bulan) {
                // jumlah rumah yang diperiksa pada RT ini untuk bulan tersebut
                $jumlahRumah = rand(8, 20);

                for ($i = 0; $i < $jumlahRumah; $i++) {
                    $penampunganBerjentik = rand(0, 100) <= 25 ? rand(1, 3) : 0; // ~25% rumah ada jentik
                    $penampunganTidakBerjentik = rand(1, 5);
                    $petugas = $users->random(); // user acak, tidak harus terikat ke RT ini

                    abj::create([
                        'id_user' => $petugas->id,
                        'id_kelurahan' => $rt->id_kelurahan,
                        'id_rt' => $rt->id,
                        'name_kepala_keluarga' => $namaKepalaKeluarga[array_rand($namaKepalaKeluarga)],
                        'penampungan_berjentik' => $penampunganBerjentik,
                        'penampungan_tidak_berjentik' => $penampunganTidakBerjentik,
                        'rumah_berjentik' => $penampunganBerjentik > 0 ? 1 : 0,
                        'rumah_tidak_berjentik' => $penampunganBerjentik == 0 ? 1 : 0,
                        'tanggal_pemeriksaan' => $bulan->copy()->addDays(rand(1, 5)), // patuh batas tgl 5 tiap bulan
                    ]);
                }
            }
        });
    }
}
