@extends('layouts.public')

@section('title', 'Gallery | RingAnnouncer Valerio')
@section('description', 'Gallery fotografica RingAnnouncer Valerio Lamanna.')
@section('activeNav', 'Gallery')

@push('styles')
<style>
    .gallery-page {
        min-height: 100vh;
        padding: 118px 0 64px;
        background: #f4efe5;
        color: #111;
    }

    .gallery-page__head {
        display: grid;
        grid-template-columns: minmax(0, 1fr) auto;
        gap: 28px;
        align-items: end;
        margin-bottom: 28px;
    }

    .gallery-page h1 {
        margin: 8px 0 0;
        font: 900 54px/.86 "Bodoni MT Poster Compressed", "Bodoni 72 Smallcaps", "Bodoni MT", Didot, Georgia, "Times New Roman", serif;
        text-transform: uppercase;
        letter-spacing: -.018em;
    }

    .gallery-page__intro {
        max-width: 680px;
        margin: 14px 0 0;
        font: 16px/1.46 Georgia, "Times New Roman", serif;
        color: #332c25;
    }

    .gallery-page__grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 12px;
    }

    .gallery-page__item {
        position: relative;
        aspect-ratio: 4 / 3;
        overflow: hidden;
        border: 1px solid rgba(196, 146, 63, .42);
        background: #111;
        cursor: pointer;
    }

    .gallery-page__item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        filter: brightness(.92) saturate(.95) contrast(1.02);
        transition: transform .28s ease, filter .28s ease;
    }

    .gallery-page__item:hover img {
        transform: scale(1.04);
        filter: brightness(1) saturate(1) contrast(1.04);
    }

    .gallery-page__item:after {
        content: "";
        position: absolute;
        inset: 0;
        background: linear-gradient(180deg, rgba(0,0,0,0), rgba(0,0,0,.28));
        opacity: 0;
        transition: opacity .24s ease;
    }

    .gallery-page__item:hover:after {
        opacity: 1;
    }

    .gallery-page__empty {
        padding: 34px;
        border: 1px solid rgba(196, 146, 63, .35);
        background: rgba(255,255,255,.52);
        font: 16px/1.45 Georgia, "Times New Roman", serif;
    }

    @media(max-width: 1120px) {
        .gallery-page__grid { grid-template-columns: repeat(3, 1fr); }
    }

    @media(max-width: 720px) {
        .gallery-page { padding-top: 96px; }
        .gallery-page__head { grid-template-columns: 1fr; align-items: start; }
        .gallery-page h1 { font-size: 42px; }
        .gallery-page__grid { grid-template-columns: repeat(2, 1fr); gap: 9px; }
    }
</style>
@endpush

@section('content')
<section class="gallery-page" id="top">
    <div class="wrap">
        <header class="gallery-page__head">
            <div>
                <div class="eyebrow">Gallery</div>
                <h1>{{ $gallery?->title ?? 'Gallery' }}</h1>
                @if(filled($gallery?->description))
                    <p class="gallery-page__intro">{{ trim(strip_tags($gallery->description)) }}</p>
                @endif
            </div>
            <a class="btn" href="{{ route('home') }}#gallery">Torna alla home</a>
        </header>

        @if($media->isNotEmpty())
            <div class="gallery-page__grid">
                @foreach($media as $image)
                    <figure class="gallery-page__item" data-gallery-modal-image="{{ $image->public_url }}" data-gallery-modal-title="{{ $image->display_title }}" role="button" tabindex="0">
                        <img src="{{ $image->thumbnail_url }}" alt="{{ $image->alt_text ?: $image->display_title }}" loading="lazy" decoding="async">
                    </figure>
                @endforeach
            </div>
            <div class="pagination-wrap">{{ $media->links() }}</div>
        @else
            <div class="gallery-page__empty">Nessuna immagine pubblicata al momento.</div>
        @endif
    </div>

    <div class="gallery-modal" data-gallery-modal hidden>
        <div class="gallery-modal__backdrop" data-gallery-close></div>
        <article class="gallery-modal__panel" role="dialog" aria-modal="true" aria-labelledby="gallery-modal-title">
            <button class="content-modal__close" type="button" data-gallery-close aria-label="Chiudi">×</button>
            <h3 id="gallery-modal-title" data-gallery-title>Gallery</h3>
            <img data-gallery-image src="" alt="">
        </article>
    </div>
</section>
@endsection