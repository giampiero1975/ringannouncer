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
            ->where('is_published', true)
            ->count();

        $bioStats = [
            'events' => (string) $publishedEventCount,
            'years' => (string) max(0, $now->year - self::RING_START_YEAR),
            'disciplines' => (string) self::COMBAT_DISCIPLINES_COUNT,
            'startYear' => (string) self::RING_START_YEAR,
        ];

        $upcomingEvents = Event::query()
            ->where('is_published', true)
            ->whereNotNull('event_date')
            ->where('event_date', '>=', $now)
            ->orderBy('event_date')
            ->limit(12)
            ->get();

        $recentEvents = Event::query()
            ->where('is_published', true)
            ->whereNotNull('event_date')
            ->where('event_date', '<', $now)
            ->orderByDesc('event_date')
            ->limit(12)
            ->get();

        $calendarEvents = Event::query()
            ->where('is_published', true)
            ->whereNotNull('event_date')
            ->orderBy('event_date')
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
