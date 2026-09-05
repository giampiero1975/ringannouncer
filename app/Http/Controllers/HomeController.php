<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Event;
use App\Models\Gallery;
use App\Models\Partner;
use App\Models\SocialLink;
use App\Models\Video;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $upcomingEvents = Event::query()
            ->where('is_published', true)
            ->whereNotNull('event_date')
            ->where('event_date', '>=', now())
            ->orderBy('event_date')
            ->limit(6)
            ->get();

        $recentEvents = Event::query()
            ->where('is_published', true)
            ->whereNotNull('event_date')
            ->where('event_date', '<', now())
            ->orderByDesc('event_date')
            ->limit(6)
            ->get();

        $articles = Article::query()
            ->where('is_published', true)
            ->orderByDesc('published_at')
            ->limit(3)
            ->get();

        $galleries = Gallery::query()
            ->where('is_published', true)
            ->withCount('media')
            ->orderByDesc('published_at')
            ->limit(4)
            ->get();

        $videos = Video::query()
            ->where('is_published', true)
            ->orderBy('sort_order')
            ->limit(4)
            ->get();

        return view('home', [
            'upcomingEvents' => $upcomingEvents,
            'recentEvents' => $recentEvents,
            'articles' => $articles,
            'galleries' => $galleries,
            'videos' => $videos,
            'partners' => Partner::where('is_active', true)->orderBy('sort_order')->get(),
            'socialLinks' => SocialLink::where('is_active', true)->orderBy('sort_order')->get(),
        ]);
    }
}
