<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

use App\Exports\LaporanHasilPemeriksaanJentikExport;
use App\Exports\RekapPendataanPerRtExport;
use Filament\Forms;
use Filament\Schemas\Schema;
use Maatwebsite\Excel\Facades\Excel;
use BackedEnum;
use Filament\Support\Icons\Heroicon;

class RekapLaporan extends Page
{   
    protected static ?string $navigationLabel = 'Rekap Laporan';
    protected static ?string $title = 'Rekap Laporan';
    protected string $view = 'filament.pages.rekap-laporan';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::DocumentText;
    public ?int $bulan = null;
    public ?int $tahun = null;

    public function mount(): void
    {
        $this->bulan = now()->month;
        $this->tahun = now()->year;
    }

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Forms\Components\Select::make('bulan')
                ->label('Bulan')
                ->options([
                    1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                    5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                    9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
                ])
                ->required(),
            Forms\Components\TextInput::make('tahun')->label('Tahun')->numeric()->required(),
        ]);
    }

    public function downloadPemeriksaan()
    {
        return Excel::download(
            new LaporanHasilPemeriksaanJentikExport($this->bulan, $this->tahun),
            "laporan-pemeriksaan-jentik-{$this->bulan}-{$this->tahun}.xlsx"
        );
    }

    public function downloadPerRt()
    {
        return Excel::download(
            new RekapPendataanPerRtExport($this->bulan, $this->tahun),
            "rekap-pendataan-per-rt-{$this->bulan}-{$this->tahun}.xlsx"
        );
    }
}
