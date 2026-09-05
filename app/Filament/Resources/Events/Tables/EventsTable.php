<?php

namespace App\Filament\Resources\Events\Tables;

use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class EventsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('event_date', 'desc')
            ->columns([
                TextColumn::make('event_date')->label('Data')->dateTime('d/m/Y H:i')->sortable(),
                TextColumn::make('title')->label('Titolo')->searchable()->sortable(),
                TextColumn::make('city')->label('Città')->searchable(),
                TextColumn::make('status')->label('Stato')->badge(),
                IconColumn::make('is_published')->label('Online')->boolean(),
                TextColumn::make('legacy_drupal_id')->label('Drupal ID')->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Stato')
                    ->options([
                        'scheduled' => 'In programma',
                        'completed' => 'Concluso',
                        'cancelled' => 'Annullato',
                        'postponed' => 'Rinviato',
                    ]),
            ])
            ->recordActions([
                EditAction::make(),
            ]);
    }
}
