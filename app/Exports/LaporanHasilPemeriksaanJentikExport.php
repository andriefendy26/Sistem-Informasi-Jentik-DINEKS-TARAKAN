<?php

namespace App\Exports;

use App\Models\abj;
use App\Models\Kelurahan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class LaporanHasilPemeriksaanJentikExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    public function __construct(protected int $bulan, protected int $tahun) {}

    /**
    * @return \Illuminate\Support\Collection
    */
     public function collection()
    {
        $rows = abj::query()
            ->selectRaw("
                id_kelurahan,
                COUNT(*) as rumah_diperiksa,
                SUM(CASE WHEN penampungan_berjentik > 0 THEN 1 ELSE 0 END) as rumah_berjentik,
                SUM(CASE WHEN penampungan_berjentik = 0 THEN 1 ELSE 0 END) as rumah_tidak_berjentik,
                SUM(penampungan_berjentik) as penampungan_berjentik,
                SUM(penampungan_tidak_berjentik) as penampungan_tidak_berjentik
            ")
            ->whereMonth('tanggal_pemeriksaan', $this->bulan)
            ->whereYear('tanggal_pemeriksaan', $this->tahun)
            ->groupBy('id_kelurahan')
            ->get()
            ->keyBy('id_kelurahan');

        return Kelurahan::query()->orderBy('name')->get()->map(function (Kelurahan $k) use ($rows) {
            $row = $rows->get($k->id);

            return (object) [
                'kelurahan' => $k->name,
                'rumah_diperiksa' => $row->rumah_diperiksa ?? 0,
                'rumah_berjentik' => $row->rumah_berjentik ?? 0,
                'rumah_tidak_berjentik' => $row->rumah_tidak_berjentik ?? 0,
                'penampungan_berjentik' => $row->penampungan_berjentik ?? 0,
                'penampungan_tidak_berjentik' => $row->penampungan_tidak_berjentik ?? 0,
            ];
        });
    }

    public function headings(): array
    {
        return ['Kelurahan', 'Rumah Diperiksa', 'Rumah Berjentik', 'Rumah Tidak Berjentik', 'Penampungan Berjentik', 'Penampungan Tidak Berjentik', 'ABJ (%)'];
    }

    public function map($row): array
    {
        $abj = $row->rumah_diperiksa > 0
            ? round(($row->rumah_tidak_berjentik / $row->rumah_diperiksa) * 100, 2)
            : 0;

        return [$row->kelurahan, $row->rumah_diperiksa, $row->rumah_berjentik, $row->rumah_tidak_berjentik, $row->penampungan_berjentik, $row->penampungan_tidak_berjentik, $abj];
    }
}
