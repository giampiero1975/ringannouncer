<?php

namespace App\Filament\Resources\Redirects;

use App\Filament\Resources\Redirects\Pages\CreateRedirect;
use App\Filament\Resources\Redirects\Pages\EditRedirect;
use App\Filament\Resources\Redirects\Pages\ListRedirects;
use App\Models\Redirect;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class RedirectResource extends Resource
{
    protected static ?string $model = Redirect::class;
    protected static ?string $navigationLabel = 'Redirect SEO';
    protected static ?string $modelLabel = 'redirect';
    protected static ?string $pluralModelLabel = 'redirect';
    protected static UnitEnum|string|null $navigationGroup = 'SEO';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Redirect')->schema([
                TextInput::make('old_path')->label('Vecchio URL')->required()->maxLength(255)->unique(ignoreRecord: true),
                TextInput::make('new_path')->label('Nuovo URL')->required()->maxLength(255),
                Select::make('status_code')->label('Codice')->options([301 => '301 permanente', 302 => '302 temporaneo'])->default(301)->required(),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('old_path')->label('Vecchio URL')->searchable()->sortable(),
            TextColumn::make('new_path')->label('Nuovo URL')->searchable(),
            TextColumn::make('status_code')->label('Codice')->badge(),
        ])->defaultSort('old_path');
    }

    public static function getPages(): array
    {
        return [
            'index' => ListRedirects::route('/'),
            'create' => CreateRedirect::route('/create'),
            'edit' => EditRedirect::route('/{record}/edit'),
        ];
    }
}
