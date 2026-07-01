<?php

namespace App\Filament\Widgets;

use App\Models\abj;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class AbjPerBulanWidget extends ChartWidget
{
    protected ?string $heading = 'Abj Per Bulan Widget';

    protected function getData(): array
    {
        $rows = abj::query()
            ->selectRaw("
                DATE_FORMAT(tanggal_pemeriksaan, '%Y-%m') as bulan,
                COUNT(*) as rumah_diperiksa,
                SUM(CASE WHEN penampungan_berjentik = 0 THEN 1 ELSE 0 END) as rumah_tidak_berjentik
            ")
            ->whereNotNull('tanggal_pemeriksaan')
            ->whereBetween('tanggal_pemeriksaan', [now()->subMonths(11)->startOfMonth(), now()->endOfMonth()])
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        return [
            'datasets' => [[
                'label' => 'ABJ (%)',
                'data' => $rows->map(fn ($r) => $r->rumah_diperiksa > 0
                    ? round(($r->rumah_tidak_berjentik / $r->rumah_diperiksa) * 100, 2)
                    : 0),
                'borderColor' => '#22c55e',
                'fill' => false,
            ]],
            'labels' => $rows->pluck('bulan')->map(fn ($b) => Carbon::createFromFormat('Y-m', $b)->translatedFormat('M Y')),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
