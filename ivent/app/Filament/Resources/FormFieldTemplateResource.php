<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventResource\Pages;
use App\Filament\Resources\EventSettingsResource\Pages\CreateEventSettings;
use App\Filament\Resources\EventSettingsResource\Pages\EditEventSettings;
use App\Filament\Resources\EventSettingsResource\Pages\ListEventSettings;
use App\Filament\Resources\FormFieldTemplateResource\Pages\CreateFormFieldTemplate;
use App\Filament\Resources\FormFieldTemplateResource\Pages\EditFormFieldTemplate;
use App\Filament\Resources\FormFieldTemplateResource\Pages\ListFormFieldTemplates;
use App\Models\Event;
use App\Models\EventSettings;
use App\Models\FormFieldTemplate;
use Filament\Resources\Resource;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;

class FormFieldTemplateResource extends Resource
{
    protected static ?string $model = FormFieldTemplate::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('event_id')
                    ->relationship('event', 'title')
                    ->required(),
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Select::make('field_type')
                    ->options([
                        'text' => 'Text',
                        'email' => 'Email',
                        'select' => 'Select',
                    ])
                    ->required(),
                TextInput::make('default_value'),
                Select::make('required')
                    ->options([
                        '0' => 'No',
                        '1' => 'Yes',
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('event.title'),
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('field_type'),
                Tables\Columns\TextColumn::make('default_value'),
                Tables\Columns\BooleanColumn::make('required'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListFormFieldTemplates::route('/'),
            'create' => CreateFormFieldTemplate::route('/create'),
            'edit' => EditFormFieldTemplate::route('/{record}/edit'),
        ];
    }
}
