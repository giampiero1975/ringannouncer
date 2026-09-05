<?php

namespace App\Filament\Resources\Galleries\RelationManagers;

use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MediaRelationManager extends RelationManager
{
    protected static string $relationship = 'media';
    protected static ?string $title = 'Foto';

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('file_path')->label('File')->required()->maxLength(255),
            TextInput::make('title')->label('Titolo')->maxLength(255),
            TextInput::make('alt_text')->label('Testo ALT')->maxLength(255),
            Textarea::make('caption')->label('Didascalia')->rows(3),
            TextInput::make('sort_order')->label('Ordine')->numeric()->default(0),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('original_name')
            ->columns([
                TextColumn::make('original_name')->label('File')->searchable(),
                TextColumn::make('title')->label('Titolo')->searchable(),
                TextColumn::make('alt_text')->label('ALT')->limit(40),
                TextColumn::make('sort_order')->label('Ordine')->sortable(),
                TextColumn::make('legacy_file_id')->label('Drupal')->toggleable(isToggledHiddenByDefault: true),
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->defaultSort('sort_order');
    }
}
