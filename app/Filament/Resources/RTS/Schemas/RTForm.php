<?php

namespace App\Filament\Resources\RTS\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\Rules\Unique;

class RTForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->numeric()
                    ->unique(
                        modifyRuleUsing: function (Unique $rule, callable $get) {
                            return $rule->where('id_kelurahan', $get('id_kelurahan'));
                        },
                        ignoreRecord: true,
                    ),
                Select::make('id_kelurahan')
                    ->relationship('Kelurahan', 'name')
                    ->live()
                    ->createOptionForm([
                        TextInput::make('name')
                            ->required(),
                    ])->required()
            ]);
    }
}
