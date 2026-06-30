<?php

namespace App\Filament\Resources\RTS\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class RTForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->numeric()
                    ->unique(),
                Select::make('id_kelurahan')
                    ->relationship('Kelurahan', 'name')
                    ->createOptionForm([
                        TextInput::make('name')
                            ->required(),
                    ])->required()
            ]);
    }
}
