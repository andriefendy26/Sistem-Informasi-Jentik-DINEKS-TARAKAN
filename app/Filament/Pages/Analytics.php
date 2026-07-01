<?php

namespace App\Filament\Pages;

use Filament\Actions\Action;
use Filament\Pages\Page;
use BackedEnum;
use Filament\Support\Icons\Heroicon;

use App\Models\abj;
use App\Models\RT;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;
use Illuminate\Database\Eloquent\Builder;


class Analytics extends Page implements HasTable
{   
    use InteractsWithTable;

    protected string $view = 'filament.pages.analytics';

    protected static ?string $navigationLabel = 'Analisa';
    protected static ?string $title = 'Analisa Laporan';
    
    protected static string|BackedEnum|null $navigationIcon = Heroicon::ChartBarSquare;
    public function getKelengkapanPercentage(): float
    {
        $totalRt = RT::count();
        if ($totalRt === 0) return 0;

        $sudahLapor = RT::query()
            ->whereHas('abj', fn (Builder $q) => $q
                ->whereMonth('tanggal_pemeriksaan', now()->month)
                ->whereYear('tanggal_pemeriksaan', now()->year))
            ->count();

        return round(($sudahLapor / $totalRt) * 100, 1);
    }

    public function getKetepatanPercentage(): float
    {
        $total = abj::query()
            ->whereMonth('tanggal_pemeriksaan', now()->month)
            ->whereYear('tanggal_pemeriksaan', now()->year)
            ->count();

        if ($total === 0) return 0;

        $tepatWaktu = abj::query()
            ->whereMonth('tanggal_pemeriksaan', now()->month)
            ->whereYear('tanggal_pemeriksaan', now()->year)
            ->whereDay('tanggal_pemeriksaan', '<=', 5)
            ->count();

        return round(($tepatWaktu / $total) * 100, 1);
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(RT::query()->with('Kelurahan'))
            ->columns([
                Tables\Columns\TextColumn::make('Kelurahan.name')->label('Kelurahan')->sortable(),
                Tables\Columns\TextColumn::make('name')->label('RT')->sortable(),
                Tables\Columns\TextColumn::make('kelengkapan')
                    ->label('Status Laporan Bulan Ini')
                    ->state(fn (RT $record) => abj::query()
                        ->where('id_rt', $record->id)
                        ->whereMonth('tanggal_pemeriksaan', now()->month)
                        ->whereYear('tanggal_pemeriksaan', now()->year)
                        ->exists() ? 'Sudah Lapor' : 'Belum Lapor')
                    ->badge()
                    ->color(fn (string $state) => $state === 'Sudah Lapor' ? 'success' : 'danger'),
                Tables\Columns\TextColumn::make('ketepatan')
                    ->label('Ketepatan Waktu (Max Tgl 5)')
                    ->state(fn (RT $record) => abj::query()
                        ->where('id_rt', $record->id)
                        ->whereMonth('tanggal_pemeriksaan', now()->month)
                        ->whereYear('tanggal_pemeriksaan', now()->year)
                        ->whereDay('tanggal_pemeriksaan', '<=', 5)
                        ->exists() ? 'Tepat Waktu' : 'Terlambat / Belum Lapor')
                    ->badge()
                    ->color(fn (string $state) => $state === 'Tepat Waktu' ? 'success' : 'warning'),
            ])
            ->defaultSort('name');
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('edit'),
            Action::make('delete')
        ];
    }
}
