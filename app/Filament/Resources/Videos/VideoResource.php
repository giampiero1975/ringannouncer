<?php

namespace App\Filament\Resources\Videos;

use App\Filament\Resources\Videos\Pages\CreateVideo;
use App\Filament\Resources\Videos\Pages\EditVideo;
use App\Filament\Resources\Videos\Pages\ListVideos;
use App\Models\Video;
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

class VideoResource extends Resource
{
    protected static ?string $model = Video::class;
    protected static ?string $recordTitleAttribute = 'title';
    protected static ?string $navigationLabel = 'Video';
    protected static ?string $modelLabel = 'video';
    protected static ?string $pluralModelLabel = 'video';
    protected static UnitEnum|string|null $navigationGroup = 'Media';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Video YouTube')->schema([
                TextInput::make('title')->label('Titolo')->required()->maxLength(255),
                TextInput::make('youtube_id')->label('YouTube ID')->required()->maxLength(64)->unique(ignoreRecord: true),
                Textarea::make('description')->label('Descrizione')->rows(5)->columnSpanFull(),
                TextInput::make('thumbnail')->label('Thumbnail'),
                DateTimePicker::make('published_at')->label('Data pubblicazione'),
                Toggle::make('is_featured')->label('In evidenza'),
                Toggle::make('is_published')->label('Pubblicato')->default(true),
                TextInput::make('sort_order')->label('Ordine')->numeric()->default(0),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('title')->label('Titolo')->searchable()->sortable(),
            TextColumn::make('youtube_id')->label('YouTube')->searchable(),
            TextColumn::make('published_at')->label('Data')->date('d/m/Y')->sortable(),
            IconColumn::make('is_featured')->label('Evidenza')->boolean(),
            IconColumn::make('is_published')->label('Pubblicato')->boolean(),
        ])->defaultSort('sort_order');
    }

    public static function getPages(): array
    {
        return [
            'index' => ListVideos::route('/'),
            'create' => CreateVideo::route('/create'),
            'edit' => EditVideo::route('/{record}/edit'),
        ];
    }
}
