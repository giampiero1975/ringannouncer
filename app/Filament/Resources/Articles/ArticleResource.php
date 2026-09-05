<?php

namespace App\Filament\Resources\Articles;

use App\Filament\Resources\Articles\Pages\CreateArticle;
use App\Filament\Resources\Articles\Pages\EditArticle;
use App\Filament\Resources\Articles\Pages\ListArticles;
use App\Models\Article;
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

class ArticleResource extends Resource
{
    protected static ?string $model = Article::class;
    protected static ?string $recordTitleAttribute = 'title';
    protected static ?string $navigationLabel = 'Curiosità';
    protected static ?string $modelLabel = 'curiosità';
    protected static ?string $pluralModelLabel = 'curiosità';
    protected static UnitEnum|string|null $navigationGroup = 'Contenuti';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Contenuto')->schema([
                TextInput::make('title')->label('Titolo')->required()->maxLength(255),
                TextInput::make('slug')->required()->maxLength(255)->unique(ignoreRecord: true),
                Textarea::make('excerpt')->label('Estratto')->rows(3)->columnSpanFull(),
                Textarea::make('content')->label('Testo')->rows(16)->columnSpanFull(),
                DateTimePicker::make('published_at')->label('Data pubblicazione'),
                TextInput::make('cover_image')->label('Immagine copertina'),
                Toggle::make('is_published')->label('Pubblicato')->default(true),
                Toggle::make('is_featured')->label('In evidenza'),
            ])->columns(2),
            Section::make('SEO')->schema([
                TextInput::make('seo_title')->label('SEO title')->maxLength(255),
                Textarea::make('seo_description')->label('Meta description')->rows(3),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('title')->label('Titolo')->searchable()->sortable(),
            TextColumn::make('published_at')->label('Data')->date('d/m/Y')->sortable(),
            IconColumn::make('is_published')->label('Pubblicato')->boolean(),
            TextColumn::make('legacy_drupal_id')->label('Drupal')->toggleable(isToggledHiddenByDefault: true),
        ])->defaultSort('published_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => ListArticles::route('/'),
            'create' => CreateArticle::route('/create'),
            'edit' => EditArticle::route('/{record}/edit'),
        ];
    }
}
