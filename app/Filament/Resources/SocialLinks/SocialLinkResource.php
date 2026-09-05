<?php

namespace App\Filament\Resources\SocialLinks;

use App\Filament\Resources\SocialLinks\Pages\CreateSocialLink;
use App\Filament\Resources\SocialLinks\Pages\EditSocialLink;
use App\Filament\Resources\SocialLinks\Pages\ListSocialLinks;
use App\Models\SocialLink;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class SocialLinkResource extends Resource
{
    protected static ?string $model = SocialLink::class;
    protected static ?string $navigationLabel = 'Social';
    protected static ?string $modelLabel = 'social';
    protected static ?string $pluralModelLabel = 'social';
    protected static UnitEnum|string|null $navigationGroup = 'Brand';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Social')->schema([
                Select::make('platform')->label('Piattaforma')->options([
                    'instagram' => 'Instagram',
                    'facebook' => 'Facebook',
                    'youtube' => 'YouTube',
                    'tiktok' => 'TikTok',
                    'x' => 'X / Twitter',
                    'linkedin' => 'LinkedIn',
                    'other' => 'Altro',
                ])->required(),
                TextInput::make('username')->label('Username'),
                TextInput::make('url')->label('URL')->url()->required(),
                TextInput::make('sort_order')->label('Ordine')->numeric()->default(0),
                Toggle::make('is_active')->label('Attivo')->default(true),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('platform')->label('Piattaforma')->badge()->sortable(),
            TextColumn::make('username')->label('Username')->searchable(),
            TextColumn::make('url')->label('URL')->limit(55),
            TextColumn::make('sort_order')->label('Ordine')->sortable(),
            IconColumn::make('is_active')->label('Attivo')->boolean(),
        ])->defaultSort('sort_order');
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSocialLinks::route('/'),
            'create' => CreateSocialLink::route('/create'),
            'edit' => EditSocialLink::route('/{record}/edit'),
        ];
    }
}
