<?php

namespace App\Filament\Resources\FormFieldTemplateResource\Pages;

use App\Filament\Resources\FormFieldTemplateResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFormFieldTemplates extends ListRecords
{
    protected static string $resource = FormFieldTemplateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
