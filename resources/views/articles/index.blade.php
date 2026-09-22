@extends('layouts.public')

@section('title', 'Curiosità | RingAnnouncer Valerio')
@section('description', 'Curiosità, storie e archivio RingAnnouncer Valerio Lamanna.')
@section('activeNav', 'Curiosità')

@push('styles')
<style>
    .listing-page {
        background: #fff;
        padding-bottom: 0;
    }

    .listing-page > .wrap {
        padding-bottom: 60px;
    }

    .listing-card span {
        margin-top: 18px;
    }

    .content-modal__panel .listing-card__cover {
        width: 100%;
        margin: 0 0 20px;
    }

    .pagination-wrap {
        display: flex;
        justify-content: center;
        margin-top: 34px;
    }

    .public-pagination {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        flex-wrap: wrap;
        font-family: "Arial Narrow", "Oswald", Arial, sans-serif;
        font-size: 12px;
        font-weight: 900;
        letter-spacing: .08em;
        text-transform: uppercase;
    }

    .public-pagination a,
    .public-pagination span {
        min-width: 38px;
        height: 38px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid rgba(169, 121, 40, .62);
        padding: 0 12px;
        color: #19140f;
        background: rgba(255, 255, 255, .42);
    }

    .public-pagination a {
        transition: background .22s ease, color .22s ease, border-color .22s ease;
    }

    .public-pagination a:hover {
        border-color: var(--gold);
        background: linear-gradient(180deg, #efc56f, #c99136);
        color: #111;
    }

    .public-pagination .is-current {
        border-color: var(--gold);
        background: #070b0d;
        color: var(--gold2);
    }

    .public-pagination .is-disabled {
        opacity: .42;
    }

    .public-pagination__step {
        min-width: 118px !important;
    }

    @media(max-width: 720px) {
        .listing-page > .wrap {
            padding-bottom: 56px;
        }

        .public-pagination {
            gap: 6px;
            font-size: 11px;
        }

        .public-pagination a,
        .public-pagination span {
            min-width: 34px;
            height: 34px;
            padding: 0 10px;
        }

        .public-pagination__step {
            min-width: auto !important;
        }
    }
</style>
@endpush

@section('content')
<section class="listing-page" id="top">
    <div class="wrap">
        <header class="listing-head">
            <div>
                <div class="eyebrow">Archivio</div>
                <h1>Curiosità</h1>
            </div>
            <a class="btn" href="{{ route('home') }}#curiosita">Torna alla home</a>
        </header>
        <div class="listing-grid">
            @foreach($articles as $article)
                @php
                    $cover = null;

                    if (filled($article->cover_image)) {
                        if (str_starts_with($article->cover_image, 'http://') || str_starts_with($article->cover_image, 'https://') || str_starts_with($article->cover_image, '/')) {
                            $cover = $article->cover_image;
                        } elseif (str_starts_with($article->cover_image, 'images/')) {
                            $cover = $imageAsset($article->cover_image);
                        } else {
                            $cover = '/storage/'.ltrim($article->cover_image, '/');
                        }
                    }

                    $body = trim(strip_tags($article->content ?: 'Contenuto in aggiornamento.'));
                @endphp
                <article class="listing-card modal-trigger" role="button" tabindex="0" data-modal-target="article-page-modal-{{ $article->id }}">
                    @if($cover)
                        <img class="listing-card__cover" src="{{ $cover }}" alt="Copertina {{ $article->title }}" loading="lazy" decoding="async">
                    @endif
                    <time>{{ optional($article->published_at)->format('d.m.Y') ?: 'Archivio' }}</time>
                    <h2>{{ $article->title }}</h2>
                    <p>{{ \Illuminate\Support\Str::limit($body, 360) }}</p>
                    <span>Leggi</span>
                </article>

                <div class="content-modal" id="article-page-modal-{{ $article->id }}" hidden>
                    <div class="content-modal__backdrop" data-modal-close></div>
                    <article class="content-modal__panel" role="dialog" aria-modal="true" aria-labelledby="article-page-title-{{ $article->id }}">
                        <button class="content-modal__close" type="button" data-modal-close aria-label="Chiudi">×</button>
                        <time class="content-modal__eyebrow">{{ optional($article->published_at)->format('d.m.Y') ?: 'Archivio' }}</time>
                        <h3 id="article-page-title-{{ $article->id }}">{{ $article->title }}</h3>
                        @if($cover)
                            <img class="listing-card__cover" src="{{ $cover }}" alt="Copertina {{ $article->title }}" loading="lazy" decoding="async">
                        @endif
                        <p>{{ \Illuminate\Support\Str::limit($body, 1400) }}</p>
                    </article>
                </div>
            @endforeach
        </div>

        @if($articles->hasPages())
            <div class="pagination-wrap">
                <nav class="public-pagination" aria-label="Paginazione curiosità">
                    @if($articles->onFirstPage())
                        <span class="public-pagination__step is-disabled">Precedenti</span>
                    @else
                        <a class="public-pagination__step" href="{{ request()->fullUrlWithQuery(['page' => $articles->currentPage() - 1]) }}" rel="prev">Precedenti</a>
                    @endif

                    @for($page = 1; $page <= $articles->lastPage(); $page++)
                        @if($page === $articles->currentPage())
                            <span class="is-current" aria-current="page">{{ str_pad((string) $page, 2, '0', STR_PAD_LEFT) }}</span>
                        @else
                            <a href="{{ request()->fullUrlWithQuery(['page' => $page]) }}">{{ str_pad((string) $page, 2, '0', STR_PAD_LEFT) }}</a>
                        @endif
                    @endfor

                    @if($articles->hasMorePages())
                        <a class="public-pagination__step" href="{{ request()->fullUrlWithQuery(['page' => $articles->currentPage() + 1]) }}" rel="next">Successive</a>
                    @else
                        <span class="public-pagination__step is-disabled">Successive</span>
                    @endif
                </nav>
            </div>
        @endif
    </div>
    <x-page-footer-separator />
</section>
@endsection
