<?php

namespace App\Filament\Resources\Events\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class EventForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Evento')
                    ->schema([
                        TextInput::make('title')->label('Titolo')->required()->maxLength(255),
                        TextInput::make('slug')->required()->maxLength(255)->unique(ignoreRecord: true),
                        Textarea::make('description')->label('Descrizione')->rows(8)->columnSpanFull(),
                        DateTimePicker::make('event_date')->label('Data evento')->required(),
                        DateTimePicker::make('event_end_date')->label('Fine evento'),
                        Select::make('status')
                            ->label('Stato')
                            ->options([
                                'scheduled' => 'In programma',
                                'completed' => 'Concluso',
                                'cancelled' => 'Annullato',
                                'postponed' => 'Rinviato',
                            ])
                            ->required(),
                        TextInput::make('venue')->label('Location'),
                        TextInput::make('city')->label('Città'),
                        TextInput::make('country')->label('Paese')->default('Italia'),
                        TextInput::make('weight_category')->label('Categoria di peso'),
                    ])->columns(2),
                Section::make('Pubblicazione')
                    ->schema([
                        Toggle::make('is_published')->label('Pubblicato')->default(true),
                        Toggle::make('is_featured')->label('In evidenza'),
                        TextInput::make('cover_image')->label('Immagine copertina'),
                    ])->columns(3),
                Section::make('SEO')
                    ->schema([
                        TextInput::make('seo_title')->label('SEO title')->maxLength(255),
                        Textarea::make('seo_description')->label('Meta description')->rows(3),
                    ]),
            ]);
    }
}
