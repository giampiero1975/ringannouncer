<x-filament-widgets::widget>
    <style>
        .ra-quick-actions {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 1rem;
        }

        .ra-quick-action {
            display: block;
            min-height: 116px;
            padding: 1.15rem 1.25rem;
            border: 1px solid color-mix(in srgb, var(--primary-500) 22%, transparent);
            border-radius: 1rem;
            background: color-mix(in srgb, var(--gray-950) 96%, var(--primary-500) 4%);
            box-shadow: 0 1px 2px rgba(15, 23, 42, .10);
            color: var(--gray-50);
            text-decoration: none;
            transition: border-color .18s ease, box-shadow .18s ease, transform .18s ease;
        }

        .ra-quick-action:hover {
            border-color: var(--primary-400);
            box-shadow: 0 14px 28px rgba(15, 23, 42, .18);
            transform: translateY(-2px);
        }

        .ra-quick-action__kicker {
            color: var(--primary-400);
            font-size: .72rem;
            font-weight: 700;
            letter-spacing: .16em;
            line-height: 1;
            text-transform: uppercase;
        }

        .ra-quick-action__title {
            margin-top: .65rem;
            color: var(--gray-50);
            font-size: 1.03rem;
            font-weight: 700;
            line-height: 1.2;
        }

        .ra-quick-action__text {
            margin-top: .3rem;
            color: var(--gray-400);
            font-size: .86rem;
            line-height: 1.35;
        }

        @media (max-width: 1024px) {
            .ra-quick-actions {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 640px) {
            .ra-quick-actions {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="ra-quick-actions">
        <a href="{{ \App\Filament\Resources\Events\EventResource::getUrl('create') }}" class="ra-quick-action">
            <div class="ra-quick-action__kicker">Evento</div>
            <div class="ra-quick-action__title">Aggiungi evento</div>
            <div class="ra-quick-action__text">Inserisci il prossimo appuntamento.</div>
        </a>

        <a href="{{ \App\Filament\Resources\Articles\ArticleResource::getUrl('create') }}" class="ra-quick-action">
            <div class="ra-quick-action__kicker">Curiosità</div>
            <div class="ra-quick-action__title">Nuova curiosità</div>
            <div class="ra-quick-action__text">Pubblica una nuova storia o curiosità.</div>
        </a>

        <a href="{{ \App\Filament\Resources\Galleries\GalleryResource::getUrl('create') }}" class="ra-quick-action">
            <div class="ra-quick-action__kicker">Immagini</div>
            <div class="ra-quick-action__title">Nuova gallery</div>
            <div class="ra-quick-action__text">Crea una raccolta fotografica.</div>
        </a>

        <a href="{{ \App\Filament\Resources\Videos\VideoResource::getUrl('create') }}" class="ra-quick-action">
            <div class="ra-quick-action__kicker">YouTube</div>
            <div class="ra-quick-action__title">Aggiungi video</div>
            <div class="ra-quick-action__text">Collega rapidamente un nuovo video.</div>
        </a>
    </div>
</x-filament-widgets::widget>
