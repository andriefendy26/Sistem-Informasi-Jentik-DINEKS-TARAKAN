<?php

namespace App\Filament\Resources\Abjs\Pages;

use App\Filament\Resources\Abjs\AbjResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAbj extends CreateRecord
{
    protected static string $resource = AbjResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['id_user'] = auth()->id();

        return $data;
    }
}
