<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Event;
use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomepageTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_renders_dynamic_navigation_and_stats(): void
    {
        Event::query()->create([
            'title' => 'Evento 1',
            'slug' => 'evento-1',
            'event_date' => now()->addDay(),
            'venue' => 'Palazzetto Test',
            'is_published' => true,
        ]);
        Event::query()->create(['title' => 'Evento 2', 'slug' => 'evento-2', 'is_published' => true]);
        Event::query()->create(['title' => 'Evento 3', 'slug' => 'evento-3', 'is_published' => true]);
        Video::query()->create(['title' => 'Video test', 'youtube_id' => 'abc123test', 'is_published' => true]);
        Article::query()->create(['title' => 'Curiosità test', 'slug' => 'curiosita-test', 'is_published' => true]);

        $this->get('/')
            ->assertOk()
            ->assertSee('Home')
            ->assertSee('Chi sono')
            ->assertSee('Video')
            ->assertSee('Curiosità')
            ->assertSee(route('events.index'), false)
            ->assertSee(route('articles.index'), false)
            ->assertSee('mini-calendar', false)
            ->assertSee('data-gallery-page', false)
            ->assertSee('data-modal-target', false)
            ->assertSee('Palazzetto Test')
            ->assertSee('3')
            ->assertSee('EVENTI ANNUNCIATI')
            ->assertSee('2004');
    }

    public function test_listing_pages_render_published_content(): void
    {
        Event::query()->create(['title' => 'Evento lista', 'slug' => 'evento-lista', 'is_published' => true]);
        Article::query()->create(['title' => 'Curiosità lista', 'slug' => 'curiosita-lista', 'is_published' => true]);

        $this->get('/eventi')
            ->assertOk()
            ->assertSee('Evento lista');

        $this->get('/curiosita')
            ->assertOk()
            ->assertSee('Curiosità lista');
    }
}
