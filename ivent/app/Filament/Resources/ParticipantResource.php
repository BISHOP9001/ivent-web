<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ParticipantResource\Pages;
use App\Filament\Resources\EventSettingsResource\Pages\CreateEventSettings;
use App\Filament\Resources\EventSettingsResource\Pages\EditEventSettings;
use App\Filament\Resources\EventSettingsResource\Pages\ListEventSettings;
use App\Filament\Resources\FormFieldTemplateResource\Pages\CreateFormFieldTemplate;
use App\Filament\Resources\FormFieldTemplateResource\Pages\EditFormFieldTemplate;
use App\Filament\Resources\FormFieldTemplateResource\Pages\ListFormFieldTemplates;
use App\Models\Event;
use App\Models\EventSettings;
use App\Models\FormFieldTemplate;
use App\Models\Participation;
use Filament\Resources\Resource;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;

class ParticipantResource extends Resource
{
    protected static ?string $model = Participation::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('event_id')
                    ->relationship('event', 'title')
                    ->required(),
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                TextInput::make('status')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('event.title'),
                Tables\Columns\TextColumn::make('user.name'),
                Tables\Columns\TextColumn::make('status'),
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
            'index' => Pages\ListParticipants::route('/'),
            'create' => Pages\CreateParticipant::route('/create'),
            'edit' => Pages\EditParticipant::route('/{record}/edit'),
        ];
    }
}
