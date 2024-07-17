<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventSettingsResource\Pages\CreateEventSettings;
use App\Filament\Resources\EventSettingsResource\Pages\EditEventSettings;
use App\Filament\Resources\EventSettingsResource\Pages\ListEventSettings;
use App\Models\EventSettings;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Filament\Tables\Actions\Action;

class EventSettingsResource extends Resource
{
    protected static ?string $model = EventSettings::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('event_id')
                    ->relationship('event', 'title')
                    ->required(),
                TextInput::make('setting_name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('setting_value')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('event.title'),
                Tables\Columns\TextColumn::make('setting_name'),
                Tables\Columns\TextColumn::make('setting_value'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Action::make('generateAccessCode')
                    ->label('Generate Access Code')
                    ->action(function (EventSettings $record) {
                        if ($record->setting_name === 'access_code') {
                            $record->setting_value = generateUniqueCode();
                            $record->save();
                        }
                    })
                    ->visible(fn (EventSettings $record) => $record->setting_name === 'access_code'),
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
            'index' => ListEventSettings::route('/'),
            'create' => CreateEventSettings::route('/create'),
            'edit' => EditEventSettings::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->whereHas('event', function ($query) {
            $query->where('created_by_user_id', Auth::id());
        });
    }
}

function generateUniqueCode(): string
{
    return strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 8));
}
