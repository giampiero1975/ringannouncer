<?php

namespace App\Filament\Widgets;

use App\Models\Article;
use App\Models\Event;
use App\Models\Gallery;
use App\Models\Video;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class RingOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $nextEvent = Event::query()
            ->where('is_published', true)
            ->whereNotNull('event_date')
            ->where('event_date', '>=', now())
            ->orderBy('event_date')
            ->first();

        return [
            Stat::make('Prossimi eventi', Event::where('is_published', true)->where('event_date', '>=', now())->count())
                ->description($nextEvent ? 'Prossimo: '.$nextEvent->title : 'Nessun evento in programma'),
            Stat::make('Archivio eventi', Event::count())
                ->description('Patrimonio storico migrato'),
            Stat::make('Curiosità', Article::count())
                ->description('Contenuti editoriali'),
            Stat::make('Media', Gallery::count().' gallery · '.Video::count().' video')
                ->description('Contenuti visuali'),
        ];
    }
}
