<?php

namespace App\Filament\Pages;

use App\Models\abj;
use App\Models\Kelurahan;
use App\Models\RT;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;
use BackedEnum;
use UnitEnum;
use Filament\Support\Icons\Heroicon;

class KirimLaporan extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::ArrowUpOnSquare;
    protected static string | UnitEnum | null $navigationGroup = 'Laporan';
    protected static ?string $navigationLabel = 'Kirim Laporan';
    protected static ?string $title = 'Kirim Laporan Pemeriksaan Jentik';
    protected string $view = 'filament.pages.kirim-laporan';


    public ?array $data = [];

    public static function canAccess(): bool
    {
        // sesuaikan nama role dengan yang kamu daftarkan di filament-shield
        return auth()->user()?->hasRole('kader') || auth()->user()?->hasRole('super_admin') ?? false;
    }

    public function mount(): void
    {
        $this->form->fill([
            'tanggal_pemeriksaan' => now()->toDateString(),
            'rumah' => [],
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->components([
                Section::make('Lokasi & Tanggal')
                    ->description('Berlaku untuk semua rumah yang diinput di bawah')
                    ->schema([
                        Select::make('id_kelurahan')
                            ->label('Kelurahan')
                            ->relationship('kelurahan', 'name')
                            ->options(Kelurahan::query()->pluck('name', 'id'))
                            ->live()
                            ->afterStateUpdated(fn (callable $set) => $set('id_rt', null))
                            ->required(),

                        Select::make('id_rt')
                            ->label('RT')
                            ->options(fn (callable $get) => RT::query()
                                ->where('id_kelurahan', $get('id_kelurahan'))
                                ->pluck('name', 'id'))
                            ->disabled(fn (callable $get) => ! $get('id_kelurahan'))
                            ->required(),

                        DatePicker::make('tanggal_pemeriksaan')
                            ->label('Tanggal Pemeriksaan')
                            ->maxDate(now())
                            ->required(),
                    ])->columns(3),

                Section::make('Data Rumah Tangga')
                    ->schema([
                        Repeater::make('rumah')
                            ->label('')
                            ->schema([
                                TextInput::make('name_kepala_keluarga')
                                    ->label('Nama Kepala Keluarga')
                                    ->required()
                                    ->columnSpan(2),

                                TextInput::make('penampungan_berjentik')
                                    ->label('Penampungan Berjentik')
                                    ->numeric()
                                    ->default(0)
                                    ->minValue(0)
                                    ->required(),

                                TextInput::make('penampungan_tidak_berjentik')
                                    ->label('Penampungan Tidak Berjentik')
                                    ->numeric()
                                    ->default(0)
                                    ->minValue(0)
                                    ->required(),
                            ])
                            ->columns(4)
                            ->addActionLabel('+ Tambah Rumah')
                            ->defaultItems(1)
                            ->reorderable(false)
                            ->required()
                            ->minItems(1),
                    ]),
            ]);
    }

    public function kirim(): void
    {
        $state = $this->form->getState();

        if (empty($state['rumah'])) {
            Notification::make()
                ->title('Minimal 1 data rumah harus diisi')
                ->danger()
                ->send();
            return;
        }

        foreach ($state['rumah'] as $rumah) {
            abj::create([
                'id_user' => auth()->id(),
                'id_kelurahan' => $state['id_kelurahan'],
                'id_rt' => $state['id_rt'],
                'tanggal_pemeriksaan' => $state['tanggal_pemeriksaan'],
                'name_kepala_keluarga' => $rumah['name_kepala_keluarga'],
                'penampungan_berjentik' => $rumah['penampungan_berjentik'],
                'penampungan_tidak_berjentik' => $rumah['penampungan_tidak_berjentik'],
            ]);
        }

        Notification::make()
            ->title(count($state['rumah']) . ' data rumah berhasil dikirim')
            ->success()
            ->send();

        $this->form->fill([
            'id_kelurahan' => null,
            'id_rt' => null,
            'tanggal_pemeriksaan' => now()->toDateString(),
            'rumah' => [],
        ]);
    }
}