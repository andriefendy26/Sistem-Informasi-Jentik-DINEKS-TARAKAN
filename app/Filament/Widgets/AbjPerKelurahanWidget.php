<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\abj;
// use Carbon\Carbon;
use App\Models\Kelurahan;

class AbjPerKelurahanWidget extends ChartWidget
{
    protected ?string $heading = 'Abj Per Kelurahan Widget';

    protected function getData(): array
    {
        $rows = abj::query()
            ->selectRaw("
                id_kelurahan,
                COUNT(*) as rumah_diperiksa,
                SUM(CASE WHEN penampungan_berjentik = 0 THEN 1 ELSE 0 END) as rumah_tidak_berjentik
            ")
            ->whereMonth('tanggal_pemeriksaan', now()->month)
            ->whereYear('tanggal_pemeriksaan', now()->year)
            ->groupBy('id_kelurahan')
            ->get()
            ->keyBy('id_kelurahan');

        $labels = [];
        $data = [];

        foreach (Kelurahan::query()->orderBy('name')->get() as $k) {
            $row = $rows->get($k->id);
            $diperiksa = $row->rumah_diperiksa ?? 0;
            $tidakBerjentik = $row->rumah_tidak_berjentik ?? 0;

            $labels[] = $k->name;
            $data[] = $diperiksa > 0 ? round(($tidakBerjentik / $diperiksa) * 100, 2) : 0;
        }

        return [
            'datasets' => [[
                'label' => 'ABJ (%)',
                'data' => $data,
                'backgroundColor' => '#6366f1',
            ]],
            'labels' => $labels,
        ];
    }
    protected function getType(): string
    {
        return 'bar';
    }
}
