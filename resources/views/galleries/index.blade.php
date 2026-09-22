@extends('layouts.public')

@section('title', 'Gallery | RingAnnouncer Valerio')
@section('description', 'Gallery fotografica RingAnnouncer Valerio Lamanna.')
@section('activeNav', 'Gallery')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/ringannouncer-gallery.css') }}?v={{ filemtime(public_path('css/ringannouncer-gallery.css')) }}">
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
                        <img src="{{ $image->thumbnail_url }}" alt="{{ $image->alt_text ?: $image->display_title }}" loading="lazy" decoding="async" onerror="this.onerror=null;this.src='{{ $image->public_url }}';">
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


















