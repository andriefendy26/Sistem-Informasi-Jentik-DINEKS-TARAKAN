<?php

namespace App\Exports;

use App\Models\abj;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;


class RekapPendataanPerRtExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    public function __construct(protected int $bulan, protected int $tahun) {}

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return abj::query()
            ->with(['Kelurahan', 'RT', 'User'])
            ->whereMonth('tanggal_pemeriksaan', $this->bulan)
            ->whereYear('tanggal_pemeriksaan', $this->tahun)
            ->orderBy('id_kelurahan')
            ->orderBy('id_rt')
            ->get();
    }

    public function headings(): array
    {
        return ['Kelurahan', 'RT', 'Nama Kepala Keluarga', 'Tanggal Pemeriksaan', 'Penampungan Berjentik', 'Penampungan Tidak Berjentik', 'Status Rumah', 'Petugas'];
    }

    public function map($row): array
    {
        return [
            $row->Kelurahan?->name,
            $row->RT?->name,
            $row->name_kepala_keluarga,
            optional($row->tanggal_pemeriksaan)->format('d-m-Y'),
            $row->penampungan_berjentik,
            $row->penampungan_tidak_berjentik,
            $row->penampungan_berjentik > 0 ? 'Berjentik' : 'Tidak Berjentik',
            $row->User?->name,
        ];
    }
}