<?php

use App\Http\Controllers\HomeController;
use App\Models\Article;
use App\Models\Event;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::get('/eventi', function () {
    return view('events.index', [
        'events' => Event::query()
            ->where('is_published', true)
            ->orderByDesc('event_date')
            ->paginate(24),
    ]);
})->name('events.index');

Route::get('/curiosita', function () {
    return view('articles.index', [
        'articles' => Article::query()
            ->where('is_published', true)
            ->orderByDesc('published_at')
            ->paginate(24),
    ]);
})->name('articles.index');
