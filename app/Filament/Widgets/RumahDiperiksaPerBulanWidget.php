<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

use App\Models\abj;
use Carbon\Carbon;

class RumahDiperiksaPerBulanWidget extends ChartWidget
{
    protected ?string $heading = 'Rumah Diperiksa Per Bulan Widget';

    protected function getData(): array
    {
        $data = abj::query()
            ->selectRaw("DATE_FORMAT(tanggal_pemeriksaan, '%Y-%m') as bulan, COUNT(*) as total")
            ->whereNotNull('tanggal_pemeriksaan')
            ->whereBetween('tanggal_pemeriksaan', [now()->subMonths(11)->startOfMonth(), now()->endOfMonth()])
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->pluck('total', 'bulan');

        return [
            'datasets' => [[
                'label' => 'Rumah Diperiksa',
                'data' => $data->values(),
                'backgroundColor' => '#3b82f6',
            ]],
            'labels' => $data->keys()->map(fn ($b) => Carbon::createFromFormat('Y-m', $b)->translatedFormat('M Y')),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
