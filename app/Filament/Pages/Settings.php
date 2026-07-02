<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use BackedEnum;
use UnitEnum;
use Filament\Support\Icons\Heroicon;

class Settings extends Page
{
    protected string $view = 'filament.pages.settings';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::Cog;
    protected static string | UnitEnum | null $navigationGroup = 'Settings';
}
