<?php

namespace App\Filament\Resources\Galleries;

use App\Filament\Resources\Galleries\Pages\CreateGallery;
use App\Filament\Resources\Galleries\Pages\EditGallery;
use App\Filament\Resources\Galleries\Pages\ListGalleries;
use App\Models\Gallery;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class GalleryResource extends Resource
{
    protected static ?string $model = Gallery::class;
    protected static ?string $recordTitleAttribute = 'title';
    protected static ?string $navigationLabel = 'Gallery';
    protected static ?string $modelLabel = 'gallery';
    protected static ?string $pluralModelLabel = 'gallery';
    protected static UnitEnum|string|null $navigationGroup = 'Media';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Gallery')->schema([
                TextInput::make('title')->label('Titolo')->required()->maxLength(255),
                TextInput::make('slug')->required()->maxLength(255)->unique(ignoreRecord: true),
                Textarea::make('description')->label('Descrizione')->rows(5)->columnSpanFull(),
                TextInput::make('cover_image')->label('Immagine copertina'),
                DateTimePicker::make('published_at')->label('Data pubblicazione'),
                Toggle::make('is_published')->label('Pubblicata')->default(true),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('title')->label('Titolo')->searchable()->sortable(),
            TextColumn::make('media_count')->counts('media')->label('Foto'),
            TextColumn::make('published_at')->label('Data')->date('d/m/Y')->sortable(),
            IconColumn::make('is_published')->label('Pubblicata')->boolean(),
            TextColumn::make('legacy_drupal_id')->label('Drupal')->toggleable(isToggledHiddenByDefault: true),
        ])->defaultSort('published_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => ListGalleries::route('/'),
            'create' => CreateGallery::route('/create'),
            'edit' => EditGallery::route('/{record}/edit'),
        ];
    }
}
