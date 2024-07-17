<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReviewResource\Pages;
use App\Models\Review;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;

class ReviewResource extends Resource
{
    protected static ?string $model = Review::class;

    protected static ?string $navigationIcon = 'heroicon-o-star';

    public static function form(Form $form): Form
    {
        // We are not using the form method since we don't allow adding or editing reviews.
        return $form;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')->label('User'),
                TextColumn::make('event.title')->label('Event'),
                TextColumn::make('rating')->label('Rating'),
                TextColumn::make('comment')->label('Comment')->wrap(),
                TextColumn::make('date_posted')->label('Posted At')->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Remove edit action
            ])
            ->bulkActions([
                // Remove bulk actions
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
            'index' => Pages\ListReviews::route('/'),
            // Remove create and edit pages
        ];
    }
}
