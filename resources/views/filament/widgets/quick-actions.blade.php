<x-filament-widgets::widget>
    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
        <a href="{{ \App\Filament\Resources\Events\EventResource::getUrl('create') }}" class="rounded-2xl border border-amber-500/20 bg-black p-5 text-white shadow-sm transition hover:-translate-y-0.5 hover:border-amber-400">
            <div class="text-xs font-semibold uppercase tracking-[0.2em] text-amber-400">Calendario</div>
            <div class="mt-2 text-lg font-bold">Aggiungi evento</div>
            <div class="mt-1 text-sm text-gray-400">Inserisci il prossimo appuntamento.</div>
        </a>

        <a href="{{ \App\Filament\Resources\Articles\ArticleResource::getUrl('create') }}" class="rounded-2xl border border-amber-500/20 bg-black p-5 text-white shadow-sm transition hover:-translate-y-0.5 hover:border-amber-400">
            <div class="text-xs font-semibold uppercase tracking-[0.2em] text-amber-400">Contenuti</div>
            <div class="mt-2 text-lg font-bold">Nuova curiosità</div>
            <div class="mt-1 text-sm text-gray-400">Pubblica una nuova storia o curiosità.</div>
        </a>

        <a href="{{ \App\Filament\Resources\Galleries\GalleryResource::getUrl('create') }}" class="rounded-2xl border border-amber-500/20 bg-black p-5 text-white shadow-sm transition hover:-translate-y-0.5 hover:border-amber-400">
            <div class="text-xs font-semibold uppercase tracking-[0.2em] text-amber-400">Immagini</div>
            <div class="mt-2 text-lg font-bold">Nuova gallery</div>
            <div class="mt-1 text-sm text-gray-400">Crea una raccolta fotografica.</div>
        </a>

        <a href="{{ \App\Filament\Resources\Videos\VideoResource::getUrl('create') }}" class="rounded-2xl border border-amber-500/20 bg-black p-5 text-white shadow-sm transition hover:-translate-y-0.5 hover:border-amber-400">
            <div class="text-xs font-semibold uppercase tracking-[0.2em] text-amber-400">YouTube</div>
            <div class="mt-2 text-lg font-bold">Aggiungi video</div>
            <div class="mt-1 text-sm text-gray-400">Collega rapidamente un nuovo video.</div>
        </a>
    </div>
</x-filament-widgets::widget>
