<?php

namespace App\Filament\Resources\EventSettingsResource\Pages;

use App\Filament\Resources\EventSettingsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEventSettings extends EditRecord
{
    protected static string $resource = EventSettingsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
