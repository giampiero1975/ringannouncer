@extends('layouts.public')

@section('title', 'Eventi | RingAnnouncer Valerio')
@section('description', 'Calendario eventi RingAnnouncer Valerio Lamanna.')
@section('activeNav', 'Eventi')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/ringannouncer-events.css') }}?v={{ filemtime(public_path('css/ringannouncer-events.css')) }}">
@endpush

@section('content')
<section class="events-page" id="top">
    <div class="events-hero">
        <div class="wrap">
            <div class="events-hero__content">
                <div class="eyebrow">Eventi</div>
                <h1>Prossimi <span>eventi</span></h1>
                <div class="events-hero__rule"></div>
                <p class="events-page__intro">Calendario, appuntamenti e serate raccontate dalla voce di Valerio.</p>
            </div>
        </div>
    </div>

    <div class="wrap events-listing">
        <div class="events-listing__bar">
            <div>
                <strong>Calendario completo</strong>
                <p>{{ $events->total() }} eventi pubblicati, ordinati per data evento.</p>
            </div>
            <a class="events-home-link" href="{{ route('home') }}#eventi">← Torna alla home</a>
        </div>

        @if($events->isNotEmpty())
            <div class="events-grid-page">
                @foreach($events as $event)
                    @php
                        if (filled($event->cover_image)) {
                            if (str_starts_with($event->cover_image, 'http://') || str_starts_with($event->cover_image, 'https://') || str_starts_with($event->cover_image, '/')) {
                                $cover = $event->cover_image;
                            } elseif (str_starts_with($event->cover_image, 'images/')) {
                                $cover = asset($event->cover_image);
                            } else {
                                $cover = '/storage/'.ltrim($event->cover_image, '/');
                            }
                        } else {
                            $fallbacks = [
                                asset('images/ringannouncer/event-boxing.webp'),
                                asset('images/ringannouncer/mockup-slices/event-card-1-clean.webp'),
                                asset('images/ringannouncer/mockup-slices/event-card-2-clean.webp'),
                                asset('images/ringannouncer/mockup-slices/event-card-3-clean.webp'),
                                asset('images/ringannouncer/mockup-slices/event-card-4-clean.webp'),
                            ];
                            $cover = $fallbacks[$loop->index % count($fallbacks)];
                        }

                        $day = optional($event->event_date)->format('d') ?: '00';
                        $month = optional($event->event_date)->translatedFormat('M');
                        $month = $month ? strtoupper($month) : 'TBA';
                        $fullDate = optional($event->event_date)->translatedFormat('d F Y, H:i') ?: 'Data da definire';
                        $location = $event->locationLabel();
                        $summary = trim(strip_tags($event->description ?: 'Dettagli evento in aggiornamento.'));
                    @endphp
                    <article class="event-list-card modal-trigger" role="button" tabindex="0" data-modal-target="event-page-modal-{{ $event->id }}">
                        <img src="{{ $cover }}" alt="Copertina {{ $event->title }}" loading="lazy" decoding="async">
                        <time class="event-list-card__date" datetime="{{ optional($event->event_date)->toDateString() }}"><strong>{{ $day }}</strong><span>{{ $month }}</span></time>
                        @if($event->is_featured)
                            <span class="event-list-card__featured">In evidenza</span>
                        @endif
                        <div class="event-list-card__body">
                            <h2>{{ $event->title }}</h2>
                            <p>{{ $location }}</p>
                            <p class="event-list-card__summary">{{ \Illuminate\Support\Str::limit($summary, 150) }}</p>
                        </div>
                        <span class="event-list-card__go" aria-hidden="true">›</span>
                    </article>

                    <div class="content-modal" id="event-page-modal-{{ $event->id }}" hidden>
                        <div class="content-modal__backdrop" data-modal-close></div>
                        <article class="content-modal__panel" role="dialog" aria-modal="true" aria-labelledby="event-page-title-{{ $event->id }}">
                            <button class="content-modal__close" type="button" data-modal-close aria-label="Chiudi">×</button>
                            <time class="content-modal__eyebrow">{{ $fullDate }}</time>
                            <h3 id="event-page-title-{{ $event->id }}">{{ $event->title }}</h3>
                            <p><strong>{{ $location }}</strong></p>
                            <p>{{ \Illuminate\Support\Str::limit($summary, 1200) }}</p>
                        </article>
                    </div>
                @endforeach
            </div>

            <div class="events-actions">
                @if($events->hasMorePages())
                    <a class="events-load-more" href="{{ $events->nextPageUrl() }}">Eventi successivi <span aria-hidden="true">↓</span></a>
                @else
                    <span></span>
                @endif
                <a class="events-home-link" href="{{ route('home') }}#eventi">← Torna alla home</a>
            </div>
        @else
            <div class="events-page__empty">Nessun evento pubblicato al momento.</div>
        @endif
    </div>
    <x-page-footer-separator />
</section>
@endsection

