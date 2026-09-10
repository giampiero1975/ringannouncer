<?php

namespace App\Filament\Resources\Events\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class EventsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort(fn (Builder $query): Builder => $query->orderByEventDate('desc'))
            ->columns([
                TextColumn::make('event_date')->label('Data')->dateTime('d/m/Y H:i')->sortable(),
                TextColumn::make('title')->label('Titolo')->searchable()->sortable(),
                TextColumn::make('venue')->label('Location')->searchable()->toggleable(),
                TextColumn::make('city')->label('Città')->searchable(),
                TextColumn::make('weight_category')->label('Disciplina')->searchable()->toggleable(),
                IconColumn::make('is_featured')->label('Evidenza')->boolean(),
                IconColumn::make('is_published')->label('Online')->boolean(),
                TextColumn::make('legacy_drupal_id')->label('Drupal ID')->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')->label('Creato')->dateTime('d/m/Y H:i')->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TernaryFilter::make('is_published')->label('Pubblicato'),
                TernaryFilter::make('is_featured')->label('In evidenza'),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
