<?php

namespace App\Filament\Resources\RTS\Pages;

use App\Filament\Resources\RTS\RTResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRTS extends ListRecords
{
    protected static string $resource = RTResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Tambahkan RT'),
        ];
    }
}
