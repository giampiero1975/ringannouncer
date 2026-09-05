<?php

namespace App\Filament\Resources\Partners;

use App\Filament\Resources\Partners\Pages\CreatePartner;
use App\Filament\Resources\Partners\Pages\EditPartner;
use App\Filament\Resources\Partners\Pages\ListPartners;
use App\Models\Partner;
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

class PartnerResource extends Resource
{
    protected static ?string $model = Partner::class;
    protected static ?string $recordTitleAttribute = 'name';
    protected static ?string $navigationLabel = 'Partner';
    protected static ?string $modelLabel = 'partner';
    protected static ?string $pluralModelLabel = 'partner';
    protected static UnitEnum|string|null $navigationGroup = 'Brand';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Partner')->schema([
                TextInput::make('name')->label('Nome')->required()->maxLength(255),
                TextInput::make('logo')->label('Logo'),
                TextInput::make('url')->label('Sito')->url(),
                Textarea::make('description')->label('Descrizione')->rows(4)->columnSpanFull(),
                TextInput::make('sort_order')->label('Ordine')->numeric()->default(0),
                Toggle::make('is_active')->label('Attivo')->default(true),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('name')->label('Nome')->searchable()->sortable(),
            TextColumn::make('url')->label('Sito')->limit(45),
            TextColumn::make('sort_order')->label('Ordine')->sortable(),
            IconColumn::make('is_active')->label('Attivo')->boolean(),
        ])->defaultSort('sort_order');
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPartners::route('/'),
            'create' => CreatePartner::route('/create'),
            'edit' => EditPartner::route('/{record}/edit'),
        ];
    }
}
