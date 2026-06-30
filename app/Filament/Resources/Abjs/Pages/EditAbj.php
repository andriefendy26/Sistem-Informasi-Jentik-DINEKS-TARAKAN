<?php

namespace App\Filament\Resources\Abjs\Pages;

use App\Filament\Resources\Abjs\AbjResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAbj extends EditRecord
{
    protected static string $resource = AbjResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
