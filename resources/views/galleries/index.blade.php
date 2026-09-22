@extends('layouts.public')

@section('title', 'Gallery | RingAnnouncer Valerio')
@section('description', 'Gallery fotografica RingAnnouncer Valerio Lamanna.')
@section('activeNav', 'Gallery')

@push('styles')
<style>
    .gallery-page {
        min-height: 100vh;
        padding: 84px 0 0;
        background: #fff;
        color: #111;
    }

    .gallery-page > .wrap {
        padding-bottom: 76px;
    }

    .gallery-hero {
        position: relative;
        min-height: 470px;
        display: grid;
        align-items: center;
        overflow: hidden;
        margin-bottom: 0;
        background: #fff url("{{ asset('images/ringannouncer/gallery-page-hero-bg.webp') }}") center center / cover no-repeat;
    }
    .gallery-hero__content {
        position: relative;
        z-index: 1;
        max-width: 690px;
        padding: 34px 0 28px;
    }

    .gallery-hero h1 {
        margin: 13px 0 18px;
        font: 900 clamp(58px, 7.4vw, 104px)/.82 "Bodoni MT Poster Compressed", "Bodoni 72 Smallcaps", "Bodoni MT", Didot, Georgia, "Times New Roman", serif;
        text-transform: uppercase;
        letter-spacing: 0;
    }

    .gallery-hero h1 span {
        display: block;
        color: var(--gold);
    }

    .gallery-hero__rule {
        width: 78px;
        height: 2px;
        margin: 0 0 16px;
        background: var(--gold);
    }

    .gallery-page__intro {
        max-width: 575px;
        margin: 0;
        font: 20px/1.34 Georgia, "Times New Roman", serif;
        color: #2b251f;
    }
    .editorial-gallery {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        grid-auto-flow: dense;
        grid-auto-rows: 8px;
        gap: 12px;
        align-items: stretch;
    }

    .editorial-gallery__item {
        position: relative;
        overflow: hidden;
        margin: 0;
        background: #070b0d;
        cursor: pointer;
        isolation: isolate;
    }

    .editorial-gallery__item.is-hero,
    .editorial-gallery__item.is-wide {
        grid-column: span 2;
    }

    .editorial-gallery__item.is-hero {
        grid-row: span 17;
    }

    .editorial-gallery__item.is-wide {
        grid-row: span 14;
    }

    .editorial-gallery__item.is-tall {
        grid-row: span 22;
    }

    .editorial-gallery__item.is-square {
        grid-row: span 15;
    }

    .editorial-gallery__item.is-small,
    .editorial-gallery__item.is-standard {
        grid-row: span 12;
    }

    .editorial-gallery__item img {
        width: 100%;
        height: 100%;
        display: block;
        object-fit: cover;
        filter: brightness(.91) saturate(.96) contrast(1.04);
        transition: transform .38s ease, filter .38s ease;
    }

    .editorial-gallery__item:after {
        content: "";
        position: absolute;
        inset: 0;
        z-index: 1;
        background: linear-gradient(180deg, rgba(0, 0, 0, 0) 42%, rgba(0, 0, 0, .54) 100%);
        opacity: .10;
        transition: opacity .34s ease;
        pointer-events: none;
    }

    .editorial-gallery__item:hover img {
        transform: scale(1.03);
        filter: brightness(1) saturate(1) contrast(1.06);
    }

    .editorial-gallery__item:hover:after {
        opacity: .64;
    }

    .editorial-gallery__caption {
        position: absolute;
        left: 17px;
        right: 17px;
        bottom: 16px;
        z-index: 2;
        color: #fff;
        opacity: 0;
        transform: translateY(8px);
        transition: opacity .3s ease, transform .3s ease;
        pointer-events: none;
    }

    .editorial-gallery__item:hover .editorial-gallery__caption {
        opacity: 1;
        transform: translateY(0);
    }

    .editorial-gallery__caption strong {
        display: block;
        font: 900 15px/1.08 "Arial Narrow", "Oswald", Arial, sans-serif;
        letter-spacing: .04em;
        text-transform: uppercase;
        text-shadow: 0 2px 10px rgba(0, 0, 0, .8);
    }

    .editorial-gallery__caption span {
        display: block;
        margin-top: 5px;
        color: var(--gold2);
        font-family: "Arial Narrow", "Oswald", Arial, sans-serif;
        font-size: 11px;
        font-weight: 900;
        letter-spacing: .12em;
        text-transform: uppercase;
    }

    .gallery-actions {
        display: flex;
        justify-content: space-between;
        gap: 18px;
        align-items: center;
        margin-top: 34px;
    }

    .gallery-load-more {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 14px;
        min-width: 228px;
        height: 46px;
        padding: 0 22px;
        border: 1px solid rgba(169, 121, 40, .76);
        color: #17120d;
        background: transparent;
        font-family: "Arial Narrow", "Oswald", Arial, sans-serif;
        font-size: 13px;
        font-weight: 900;
        letter-spacing: .06em;
        text-transform: uppercase;
        text-decoration: none;
        transition: background .24s ease, color .24s ease, border-color .24s ease;
    }

    .gallery-load-more:hover {
        border-color: var(--gold);
        background: linear-gradient(180deg, #efc56f, #c99136);
        color: #111;
    }

    .gallery-home-link {
        color: #3a3026;
        font: 15px/1.2 Georgia, "Times New Roman", serif;
        text-decoration: underline;
        text-underline-offset: 4px;
    }

    .gallery-page__empty {
        padding: 34px;
        border: 1px solid rgba(196, 146, 63, .35);
        background: rgba(255, 255, 255, .52);
        font: 16px/1.45 Georgia, "Times New Roman", serif;
    }

    .gallery-modal__nav {
        position: absolute;
        top: 50%;
        z-index: 3;
        width: 44px;
        height: 56px;
        border: 1px solid rgba(229, 189, 114, .74);
        background: rgba(5, 9, 10, .58);
        color: var(--gold2);
        font-size: 34px;
        line-height: 1;
        transform: translateY(-50%);
        cursor: pointer;
    }

    .gallery-modal__nav:hover {
        background: rgba(196, 146, 63, .22);
    }

    .gallery-modal__nav.is-prev {
        left: 18px;
    }

    .gallery-modal__nav.is-next {
        right: 18px;
    }

    .gallery-modal__panel {
        padding-left: 78px;
        padding-right: 78px;
    }

    @media(max-width: 1120px) {
        .gallery-hero {
            min-height: 410px;
        }

        .editorial-gallery {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .editorial-gallery__item.is-hero,
        .editorial-gallery__item.is-wide {
            grid-column: span 2;
        }
    }

    @media(max-width: 720px) {
        .gallery-page {
            padding-top: 76px;
        }

        .gallery-page > .wrap {
            padding-bottom: 56px;
        }

        .gallery-hero {
            min-height: auto;
            padding: 38px 0 32px;
        }

        .gallery-hero h1 {
            font-size: 52px;
        }

        .gallery-page__intro {
            font-size: 17px;
        }

        .editorial-gallery {
            grid-template-columns: 1fr;
        }

        .editorial-gallery__item,
        .editorial-gallery__item.is-hero,
        .editorial-gallery__item.is-wide,
        .editorial-gallery__item.is-tall,
        .editorial-gallery__item.is-square,
        .editorial-gallery__item.is-small,
        .editorial-gallery__item.is-standard {
            grid-column: auto;
            min-height: 0;
            grid-row: auto;
            aspect-ratio: 4 / 3;
        }

        .gallery-actions {
            display: grid;
            justify-items: start;
        }

        .gallery-modal__panel {
            padding-left: 12px;
            padding-right: 12px;
        }

        .gallery-modal__nav {
            top: auto;
            bottom: 16px;
            width: 42px;
            height: 42px;
            font-size: 28px;
            transform: none;
        }

        .gallery-modal__nav.is-prev {
            left: 16px;
        }

        .gallery-modal__nav.is-next {
            right: 16px;
        }
    }
</style>
@endpush

@section('content')
<section class="gallery-page" id="top">
    <div class="gallery-hero">
        <div class="wrap">
            <div class="gallery-hero__content">
                <div class="eyebrow">Gallery</div>
                <h1>Momenti <span>che restano</span></h1>
                <div class="gallery-hero__rule"></div>
                <p class="gallery-page__intro">Il ring, gli incontri, le persone. Una storia raccontata attraverso le immagini.</p>
            </div>
        </div>
    </div>

    <div class="wrap">
        @if($media->isNotEmpty())
            <div class="editorial-gallery">
                @foreach($media as $image)
                    @php
                        $pattern = [
                            'is-hero has-caption',
                            'is-tall has-caption',
                            'is-small',
                            'is-small',
                            'is-small',
                            'is-small',
                            'is-wide has-caption',
                            'is-wide',
                            'is-small',
                            'is-square',
                            'is-small',
                            'is-wide has-caption',
                        ];
                        $itemClass = $pattern[$loop->index % count($pattern)];
                        $showCaption = str_contains($itemClass, 'has-caption');
                    @endphp
                    <figure class="editorial-gallery__item {{ $itemClass }}" data-gallery-modal-image="{{ $image->public_url }}" data-gallery-modal-title="{{ $image->display_title }}" role="button" tabindex="0">
                        <img src="{{ $image->thumbnail_url }}" alt="{{ $image->alt_text ?: $image->display_title }}" loading="lazy" decoding="async">
                        @if($showCaption)
                            <figcaption class="editorial-gallery__caption">
                                <strong>{{ $image->display_title }}</strong>
                                <span>RingAnnouncer</span>
                            </figcaption>
                        @endif
                    </figure>
                @endforeach
            </div>

            <div class="gallery-actions">
                @if($media->hasMorePages())
                    <a class="gallery-load-more" href="{{ $media->nextPageUrl() }}">Carica altre foto <span aria-hidden="true">↓</span></a>
                @else
                    <span></span>
                @endif
                <a class="gallery-home-link" href="{{ route('home') }}#gallery">← Torna alla home</a>
            </div>
        @else
            <div class="gallery-page__empty">Nessuna immagine pubblicata al momento.</div>
        @endif
    </div>

    <div class="gallery-modal" data-gallery-modal hidden>
        <div class="gallery-modal__backdrop" data-gallery-close></div>
        <article class="gallery-modal__panel" role="dialog" aria-modal="true" aria-labelledby="gallery-modal-title">
            <button class="content-modal__close" type="button" data-gallery-close aria-label="Chiudi">×</button>
            <button class="gallery-modal__nav is-prev" type="button" data-gallery-prev aria-label="Foto precedente">‹</button>
            <button class="gallery-modal__nav is-next" type="button" data-gallery-next aria-label="Foto successiva">›</button>
            <h3 id="gallery-modal-title" data-gallery-title>Gallery</h3>
            <img data-gallery-image src="" alt="">
        </article>
    </div>
    <x-page-footer-separator />
</section>
@endsection


















