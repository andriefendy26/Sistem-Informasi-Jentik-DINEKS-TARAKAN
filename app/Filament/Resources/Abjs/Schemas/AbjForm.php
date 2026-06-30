<?php

namespace App\Filament\Resources\Abjs\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;

class AbjForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Lokasi')
                    ->description('Isi sesuai lokasi pengisian data')
                    ->schema([
                        Select::make('id_kelurahan')
                            ->label("Kelurahan")
                            ->relationship('Kelurahan', 'name')
                            ->required(),
                        Select::make('id_rt')
                            ->label("RT")
                            ->relationship('RT', 'name')
                            ->required(),
                ])->columns(2)->columnSpan('full'),
                Section::make('Lokasi')
                    ->description('Isi sesuai lokasi pengisian data')
                    ->schema([
                        TextInput::make('name_kepala_keluarga')
                            ->required()
                            ->columnSpan('full'),
                        TextInput::make('penampungan_berjentik')
                            ->numeric()
                            ->required(),
                        TextInput::make('penampungan_tidak_berjentik')
                            ->numeric()
                            ->required(),
                        TextInput::make('rumah_berjentik')
                            ->numeric()
                            ->required(),
                        TextInput::make('rumah_tidak_berjentik')
                            ->numeric()
                            ->required(),
                ])->columns(2)->columnSpan('full'),
             
            ]);
    }
}
