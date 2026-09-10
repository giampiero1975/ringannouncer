<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Event;
use App\Models\Partner;
use App\Models\SiteSetting;
use App\Models\Video;
use Illuminate\View\View;

class HomeController extends Controller
{
    private const RING_START_YEAR = 2004;

    private const COMBAT_DISCIPLINES_COUNT = 4;

    public function __invoke(): View
    {
        $now = now();
        $publishedEventCount = Event::query()
            ->published()
            ->count();

        $bioStats = [
            'events' => (string) $publishedEventCount,
            'years' => (string) max(0, $now->year - self::RING_START_YEAR),
            'disciplines' => (string) self::COMBAT_DISCIPLINES_COUNT,
            'startYear' => (string) self::RING_START_YEAR,
        ];

        $upcomingEvents = Event::query()
            ->published()
            ->withEventDate()
            ->where('event_date', '>=', $now)
            ->orderByEventDate('desc')
            ->limit(12)
            ->get();

        $recentEvents = Event::query()
            ->published()
            ->withEventDate()
            ->where('event_date', '<', $now)
            ->orderByEventDate('desc')
            ->limit(12)
            ->get();

        $calendarEvents = Event::query()
            ->published()
            ->withEventDate()
            ->orderByEventDate()
            ->get(['title', 'event_date', 'venue', 'city'])
            ->map(fn (Event $event) => [
                'title' => $event->title,
                'date' => $event->event_date?->toDateString(),
                'venue' => $event->venue ?: $event->city,
            ])
            ->filter(fn (array $event) => filled($event['date']))
            ->values();

        $articles = Article::query()
            ->where('is_published', true)
            ->orderByDesc('published_at')
            ->limit(9)
            ->get();

        $videos = Video::query()
            ->where('is_published', true)
            ->orderBy('sort_order')
            ->get();

        return view('home', [
            'settings' => SiteSetting::query()->first(),
            'upcomingEvents' => $upcomingEvents,
            'recentEvents' => $recentEvents,
            'calendarEvents' => $calendarEvents,
            'articles' => $articles,
            'videos' => $videos,
            'partners' => Partner::where('is_active', true)->orderBy('sort_order')->get(),
            'bioStats' => $bioStats,
        ]);
    }
}
