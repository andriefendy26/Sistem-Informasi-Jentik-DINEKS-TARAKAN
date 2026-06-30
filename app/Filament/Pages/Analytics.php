<?php

namespace App\Filament\Pages;

use Filament\Actions\Action;
// use Filament\Support\Enums\Alignment;
use Filament\Pages\Page;
use BackedEnum;
use Filament\Support\Icons\Heroicon;

class Analytics extends Page
{
    protected string $view = 'filament.pages.analytics';
    // protected ?Alignment $headerActionsAlignment = Alignment::Center;
    // protected static ?string $title = 'Custom Page Title';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::ChartBarSquare;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('edit'),
            Action::make('delete')
        ];
    }
}
