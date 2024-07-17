<?php

namespace App\Filament\Resources\EventSettingsResource\Pages;

use App\Filament\Resources\EventSettingsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEventSettings extends ListRecords
{
    protected static string $resource = EventSettingsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
