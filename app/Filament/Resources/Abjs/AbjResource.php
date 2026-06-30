<?php

namespace App\Filament\Resources\Abjs;

use App\Filament\Resources\Abjs\Pages\CreateAbj;
use App\Filament\Resources\Abjs\Pages\EditAbj;
use App\Filament\Resources\Abjs\Pages\ListAbjs;
use App\Filament\Resources\Abjs\Schemas\AbjForm;
use App\Filament\Resources\Abjs\Tables\AbjsTable;
use App\Models\Abj;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AbjResource extends Resource
{
    protected static ?string $model = Abj::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name_kepala_keluarga';
    protected static ?string $pluralModelLabel = 'data ABJ (Angka Bebas Jentik)';
    
    public static function form(Schema $schema): Schema
    {
        return AbjForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AbjsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    
    public static function getPages(): array
    {
        return [
            'index' => ListAbjs::route('/'),
            'create' => CreateAbj::route('/create'),
            'edit' => EditAbj::route('/{record}/edit'),
        ];
    }
}
