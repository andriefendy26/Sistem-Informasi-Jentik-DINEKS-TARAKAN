<?php

namespace App\Filament\Resources\Abjs\Pages;

use App\Filament\Resources\Abjs\AbjResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAbjs extends ListRecords
{
    protected static string $resource = AbjResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
