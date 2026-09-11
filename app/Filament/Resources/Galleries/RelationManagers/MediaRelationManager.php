<?php

namespace App\Filament\Resources\Galleries\RelationManagers;

use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MediaRelationManager extends RelationManager
{
    protected static string $relationship = 'media';
    protected static ?string $title = 'Foto';

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            FileUpload::make('file_path')
                ->label('Immagine')
                ->image()
                ->disk('public')
                ->directory('galleries/photos')
                ->visibility('public')
                ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                ->maxSize(6144)
                ->required()
                ->columnSpanFull(),
            TextInput::make('title')->label('Titolo')->maxLength(255),
            TextInput::make('alt_text')->label('Testo ALT')->maxLength(255),
            Textarea::make('caption')->label('Didascalia')->rows(3)->columnSpanFull(),
            TextInput::make('sort_order')->label('Ordine')->numeric()->default(0),
            Toggle::make('show_on_home')->label('Mostra in home'),
        ])->columns(2);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                ImageColumn::make('file_path')->label('Foto')->disk('public')->square(),
                TextColumn::make('title')->label('Titolo')->searchable()->placeholder('Senza titolo'),
                TextColumn::make('alt_text')->label('ALT')->limit(40)->placeholder('Non impostato'),
                TextColumn::make('sort_order')->label('Ordine')->sortable(),
                IconColumn::make('show_on_home')->label('Home')->boolean(),
                TextColumn::make('legacy_file_id')->label('Drupal')->toggleable(isToggledHiddenByDefault: true),
            ])
            ->headerActions([
                CreateAction::make()->label('Aggiungi foto'),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->defaultSort('sort_order');
    }
}