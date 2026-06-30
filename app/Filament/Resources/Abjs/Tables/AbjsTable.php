<?php

namespace App\Filament\Resources\Abjs\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AbjsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name_kepala_keluarga')
                    ->searchable(),
                TextColumn::make('penampungan_berjentik')
                    ->searchable(),
                TextColumn::make('penampungan_tidak_berjentik')
                    ->searchable(),
                TextColumn::make('rumah_berjentik')
                    ->searchable(),
                TextColumn::make('rumah_tidak_berjentik')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
