<?php

use App\Http\Controllers\HomeController;
use App\Models\Article;
use App\Models\Event;
use App\Models\Page;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::get('/eventi', function () {
    return view('events.index', [
        'events' => Event::query()
            ->published()
            ->orderByEventDate('desc')
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

Route::get('/pagine/{page:key}', function (Page $page) {
    return redirect()->route('pages.show', $page, 301);
})->name('pages.legacy');

Route::get('/{page:key}', function (Page $page) {
    abort_unless($page->is_published, 404);

    if ($page->key === 'home') {
        return redirect()->route('home', status: 301);
    }

    return view('pages.show', [
        'page' => $page,
    ]);
})->name('pages.show');
