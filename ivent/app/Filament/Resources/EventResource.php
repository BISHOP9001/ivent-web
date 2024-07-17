<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventResource\Pages;
use App\Models\Event;
use Filament\Resources\Resource;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Builder as NestedBuilder;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Fieldset;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Textarea::make('description')
                    ->required(),
                DatePicker::make('start_date')
                    ->required(),
                DatePicker::make('end_date')
                    ->required(),
                Fieldset::make('Location')
                    ->schema([
                        TextInput::make('location.address')
                            ->label('Address')
                            ->required(),
                        TextInput::make('location.city')
                            ->label('City')
                            ->required(),
                        TextInput::make('location.country')
                            ->label('Country')
                            ->required(),
                    ]),
                Select::make('category_id')
                    ->relationship('category', 'name')
                    ->required(),
                Checkbox::make('payment_required'),
                Select::make('event_type')
                    ->options([
                        'public' => 'Public',
                        'private' => 'Private',
                    ])
                    ->required(),


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('description')->limit(50),
                Tables\Columns\TextColumn::make('event_type'),
                Tables\Columns\TextColumn::make('start_date')->dateTime(),
                Tables\Columns\TextColumn::make('end_date')->dateTime(),
                Tables\Columns\TextColumn::make('location.address'),
                Tables\Columns\TextColumn::make('category.name'),
                Tables\Columns\BooleanColumn::make('payment_required'),


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
            'index' => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvent::route('/create'),
            'edit' => Pages\EditEvent::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('created_by_user_id', auth()->user()->id);
    }
}
