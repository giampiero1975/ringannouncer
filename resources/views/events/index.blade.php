@extends('layouts.public')

@section('title', 'Eventi | RingAnnouncer Valerio')
@section('description', 'Calendario eventi RingAnnouncer Valerio Lamanna.')
@section('activeNav', 'Eventi')

@push('styles')
<style>
    .events-page {
        min-height: 100vh;
        padding: 84px 0 0;
        background: #fff;
        color: #111;
    }

    .events-hero {
        position: relative;
        min-height: 420px;
        display: grid;
        align-items: center;
        overflow: hidden;
        background: #fff url("{{ asset('images/ringannouncer/events-page-hero-bg.webp') }}") center center / cover no-repeat;
    }

    .events-hero__content {
        max-width: 690px;
        padding: 34px 0 28px;
    }

    .events-hero h1 {
        margin: 13px 0 18px;
        font: 900 clamp(58px, 7.4vw, 104px)/.82 "Bodoni MT Poster Compressed", "Bodoni 72 Smallcaps", "Bodoni MT", Didot, Georgia, "Times New Roman", serif;
        text-transform: uppercase;
        letter-spacing: 0;
    }

    .events-hero h1 span {
        display: block;
        color: var(--gold);
    }

    .events-hero__rule {
        width: 78px;
        height: 2px;
        margin: 0 0 16px;
        background: var(--gold);
    }

    .events-page__intro {
        max-width: 575px;
        margin: 0;
        font: 20px/1.34 Georgia, "Times New Roman", serif;
        color: #2b251f;
    }

    .events-listing {
        padding-top: 8px;
        padding-bottom: 76px;
    }

    .events-listing__bar {
        display: flex;
        align-items: end;
        justify-content: space-between;
        gap: 24px;
        margin: 0 0 26px;
        border-bottom: 1px solid rgba(196, 146, 63, .28);
        padding-bottom: 18px;
    }

    .events-listing__bar p {
        margin: 0;
        color: #5f554a;
        font: 15px/1.35 Georgia, "Times New Roman", serif;
    }

    .events-listing__bar strong {
        display: block;
        color: #111;
        font-family: "Arial Narrow", "Oswald", Arial, sans-serif;
        font-size: 13px;
        font-weight: 900;
        letter-spacing: .12em;
        text-transform: uppercase;
    }

    .events-grid-page {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 14px;
    }

    .event-list-card {
        position: relative;
        min-height: 330px;
        overflow: hidden;
        border: 1px solid rgba(196, 146, 63, .46);
        background: #070b0d;
        color: #fff;
        cursor: pointer;
        isolation: isolate;
    }

    .event-list-card img {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        filter: brightness(.78) saturate(.96) contrast(1.04);
        transition: transform .38s ease, filter .38s ease;
        z-index: 0;
    }

    .event-list-card:before {
        content: "";
        position: absolute;
        inset: 0;
        z-index: 1;
        background: linear-gradient(180deg, rgba(0, 0, 0, .06) 22%, rgba(0, 0, 0, .88) 100%);
        pointer-events: none;
    }

    .event-list-card:hover img {
        transform: scale(1.03);
        filter: brightness(.92) saturate(1) contrast(1.06);
    }

    .event-list-card__date {
        position: absolute;
        left: 0;
        top: 0;
        z-index: 3;
        width: 74px;
        padding: 12px 8px 10px;
        background: #050607;
        color: #fff;
        text-align: center;
        text-transform: uppercase;
    }

    .event-list-card__date strong {
        display: block;
        font-size: 34px;
        line-height: .92;
    }

    .event-list-card__date span {
        display: block;
        margin-top: 5px;
        font-family: "Arial Narrow", "Oswald", Arial, sans-serif;
        font-size: 13px;
        font-weight: 900;
        letter-spacing: .04em;
    }

    .event-list-card__featured {
        position: absolute;
        top: 12px;
        right: 12px;
        z-index: 3;
        border: 1px solid rgba(229, 189, 114, .7);
        background: rgba(5, 7, 8, .72);
        color: var(--gold2);
        padding: 7px 10px;
        font-family: "Arial Narrow", "Oswald", Arial, sans-serif;
        font-size: 11px;
        font-weight: 900;
        letter-spacing: .12em;
        text-transform: uppercase;
    }

    .event-list-card__body {
        position: absolute;
        z-index: 2;
        left: 20px;
        right: 52px;
        bottom: 19px;
    }

    .event-list-card h2 {
        margin: 0 0 11px;
        font-family: "Arial Narrow", "Oswald", Arial, sans-serif;
        font-size: 23px;
        font-weight: 900;
        line-height: 1;
        letter-spacing: .02em;
        text-transform: uppercase;
        text-shadow: 0 2px 10px rgba(0, 0, 0, .78);
    }

    .event-list-card p {
        margin: 7px 0;
        color: #f7eee2;
        font-size: 13px;
        font-weight: 700;
        line-height: 1.2;
        text-shadow: 0 2px 8px rgba(0, 0, 0, .72);
    }

    .event-list-card__summary {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        font-family: Georgia, "Times New Roman", serif;
        font-weight: 400 !important;
    }

    .event-list-card__go {
        position: absolute;
        right: 17px;
        bottom: 17px;
        z-index: 3;
        width: 38px;
        height: 38px;
        border: 1px solid rgba(255, 255, 255, .9);
        border-radius: 50%;
        display: grid;
        place-items: center;
        font-size: 24px;
        line-height: 1;
    }

    .events-actions {
        display: flex;
        justify-content: space-between;
        gap: 18px;
        align-items: center;
        margin-top: 34px;
    }

    .events-load-more,
    .events-home-link {
        color: #3a3026;
    }

    .events-load-more {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 14px;
        min-width: 228px;
        height: 46px;
        padding: 0 22px;
        border: 1px solid rgba(169, 121, 40, .76);
        background: transparent;
        font-family: "Arial Narrow", "Oswald", Arial, sans-serif;
        font-size: 13px;
        font-weight: 900;
        letter-spacing: .06em;
        text-transform: uppercase;
        text-decoration: none;
        transition: background .24s ease, color .24s ease, border-color .24s ease;
    }

    .events-load-more:hover {
        border-color: var(--gold);
        background: linear-gradient(180deg, #efc56f, #c99136);
        color: #111;
    }

    .events-home-link {
        font: 15px/1.2 Georgia, "Times New Roman", serif;
        text-decoration: underline;
        text-underline-offset: 4px;
    }

    .events-page__empty {
        padding: 34px;
        border: 1px solid rgba(196, 146, 63, .35);
        background: rgba(255, 255, 255, .52);
        font: 16px/1.45 Georgia, "Times New Roman", serif;
    }

    @media(max-width: 1120px) {
        .events-hero {
            min-height: 390px;
        }

        .events-grid-page {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media(max-width: 720px) {
        .events-page {
            padding-top: 76px;
        }

        .events-listing {
            padding-bottom: 56px;
        }

        .events-hero {
            min-height: auto;
            padding: 38px 0 32px;
        }

        .events-hero h1 {
            font-size: 52px;
        }

        .events-page__intro {
            font-size: 17px;
        }

        .events-listing__bar,
        .events-actions {
            display: grid;
            justify-items: start;
        }

        .events-grid-page {
            grid-template-columns: 1fr;
        }

        .event-list-card {
            min-height: 285px;
        }
    }
</style>
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

