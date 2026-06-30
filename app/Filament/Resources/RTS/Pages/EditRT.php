<?php

namespace App\Filament\Resources\RTS\Pages;

use App\Filament\Resources\RTS\RTResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditRT extends EditRecord
{
    protected static string $resource = RTResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
