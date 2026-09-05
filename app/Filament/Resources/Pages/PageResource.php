<?php

namespace App\Filament\Resources\Pages;

use App\Filament\Resources\Pages\Pages\EditPage;
use App\Filament\Resources\Pages\Pages\ListPages;
use App\Models\Page;
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

class PageResource extends Resource
{
    protected static ?string $model = Page::class;
    protected static ?string $recordTitleAttribute = 'title';
    protected static ?string $navigationLabel = 'Pagine';
    protected static ?string $modelLabel = 'pagina';
    protected static ?string $pluralModelLabel = 'pagine';
    protected static UnitEnum|string|null $navigationGroup = 'Contenuti';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Pagina')->schema([
                TextInput::make('key')->label('Chiave')->required()->maxLength(255)->unique(ignoreRecord: true),
                TextInput::make('title')->label('Titolo')->required()->maxLength(255),
                Textarea::make('content')->label('Contenuto')->rows(18)->columnSpanFull(),
                Toggle::make('is_published')->label('Pubblicata')->default(true),
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
            TextColumn::make('key')->label('Chiave')->badge(),
            IconColumn::make('is_published')->label('Pubblicata')->boolean(),
            TextColumn::make('legacy_drupal_id')->label('Drupal')->toggleable(isToggledHiddenByDefault: true),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPages::route('/'),
            'edit' => EditPage::route('/{record}/edit'),
        ];
    }
}
