<?php

namespace App\Filament\Resources\SiteSettings;

use App\Filament\Resources\SiteSettings\Pages\EditSiteSetting;
use App\Filament\Resources\SiteSettings\Pages\ListSiteSettings;
use App\Models\SiteSetting;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class SiteSettingResource extends Resource
{
    protected static ?string $model = SiteSetting::class;
    protected static ?string $navigationLabel = 'Homepage';
    protected static ?string $modelLabel = 'homepage';
    protected static ?string $pluralModelLabel = 'homepage';
    protected static UnitEnum|string|null $navigationGroup = 'Sito';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Hero')->description('Tutti i contenuti e lo sfondo principale sono sostituibili.')->schema([
                TextInput::make('hero_eyebrow')->label('Sovratitolo'),
                TextInput::make('hero_line_1')->label('Titolo riga 1')->required(),
                TextInput::make('hero_line_2')->label('Titolo riga 2')->required(),
                TextInput::make('hero_line_3')->label('Titolo riga 3')->required(),
                Textarea::make('hero_intro')->label('Testo introduttivo')->rows(3)->columnSpanFull(),
                FileUpload::make('hero_image')->label('Immagine / sfondo hero')->image()->disk('public')->directory('site/hero')->columnSpanFull(),
                TextInput::make('hero_cta_text')->label('Testo pulsante'),
                TextInput::make('hero_cta_url')->label('Link pulsante'),
                TextInput::make('hero_video_text')->label('Testo video'),
                TextInput::make('hero_video_url')->label('Link video'),
                TextInput::make('signature_name')->label('Firma'),
                TextInput::make('hero_side_line_1')->label('Valore 1'),
                TextInput::make('hero_side_line_2')->label('Valore 2'),
                TextInput::make('hero_side_line_3')->label('Valore 3'),
            ])->columns(2),

            Section::make('Eventi')->description('Le immagini delle singole card si gestiscono dagli Eventi; qui si controlla lo sfondo della sezione.')->schema([
                TextInput::make('events_eyebrow')->label('Sovratitolo'),
                TextInput::make('events_title')->label('Titolo'),
                Textarea::make('events_intro')->label('Testo')->rows(3)->columnSpanFull(),
                FileUpload::make('events_background_image')->label('Sfondo sezione eventi')->image()->disk('public')->directory('site/backgrounds/events')->columnSpanFull(),
            ])->columns(2),

            Section::make('Gallery')->description('Le foto del mosaico si gestiscono dalle Gallery; lo sfondo decorativo è indipendente e sostituibile.')->schema([
                TextInput::make('gallery_eyebrow')->label('Sovratitolo'),
                TextInput::make('gallery_title')->label('Titolo'),
                Textarea::make('gallery_intro')->label('Testo')->rows(3)->columnSpanFull(),
                FileUpload::make('gallery_background_image')->label('Sfondo sezione gallery')->image()->disk('public')->directory('site/backgrounds/gallery')->columnSpanFull(),
            ])->columns(2),

            Section::make('Biografia')->description('Foto principale e texture/sfondo della fascia sono gestite separatamente.')->schema([
                TextInput::make('bio_eyebrow')->label('Sovratitolo'),
                TextInput::make('bio_title')->label('Titolo'),
                Textarea::make('bio_body')->label('Biografia')->rows(6)->columnSpanFull(),
                Textarea::make('bio_quote')->label('Citazione')->rows(3)->columnSpanFull(),
                FileUpload::make('bio_image')->label('Foto biografia')->image()->disk('public')->directory('site/bio'),
                FileUpload::make('bio_background_image')->label('Sfondo / texture biografia')->image()->disk('public')->directory('site/backgrounds/bio'),
            ])->columns(2),

            Section::make('Numeri')->schema([
                TextInput::make('stat_events')->label('Eventi'),
                TextInput::make('stat_events_label')->label('Etichetta eventi'),
                TextInput::make('stat_cities')->label('Città'),
                TextInput::make('stat_cities_label')->label('Etichetta città'),
                TextInput::make('stat_disciplines')->label('Discipline'),
                TextInput::make('stat_disciplines_label')->label('Etichetta discipline'),
                TextInput::make('stat_unique')->label('Valore passione'),
                TextInput::make('stat_unique_label')->label('Etichetta passione'),
            ])->columns(2),

            Section::make('Call to action finale')->description('Anche la fascia con le corde del ring è uno sfondo sostituibile.')->schema([
                TextInput::make('cta_eyebrow')->label('Sovratitolo'),
                TextInput::make('cta_title')->label('Titolo'),
                TextInput::make('cta_text')->label('Testo'),
                TextInput::make('cta_button_text')->label('Testo pulsante'),
                TextInput::make('cta_button_url')->label('Link pulsante'),
                FileUpload::make('cta_background_image')->label('Sfondo CTA')->image()->disk('public')->directory('site/cta')->columnSpanFull(),
                TextInput::make('footer_tagline')->label('Tagline footer')->columnSpanFull(),
                FileUpload::make('footer_background_image')->label('Sfondo footer')->image()->disk('public')->directory('site/backgrounds/footer')->columnSpanFull(),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('hero_line_1')->label('Homepage'),
            TextColumn::make('updated_at')->label('Ultima modifica')->dateTime('d/m/Y H:i'),
        ]);
    }

    public static function canCreate(): bool
    {
        return SiteSetting::query()->doesntExist();
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSiteSettings::route('/'),
            'edit' => EditSiteSetting::route('/{record}/edit'),
        ];
    }
}
