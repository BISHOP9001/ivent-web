<?php

namespace App\Filament\Resources\FormFieldTemplateResource\Pages;

use App\Filament\Resources\FormFieldTemplateResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFormFieldTemplate extends EditRecord
{
    protected static string $resource = FormFieldTemplateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
