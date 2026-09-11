@extends('layouts.public')

@section('title', 'Curiosità | RingAnnouncer Valerio')
@section('description', 'Curiosità, storie e archivio RingAnnouncer Valerio Lamanna.')
@section('activeNav', 'Curiosità')

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
                            $cover = \Illuminate\Support\Facades\Storage::url($article->cover_image);
                        }
                    }

                    $body = trim(strip_tags($article->content ?: 'Contenuto in aggiornamento.'));
                @endphp
                <article class="listing-card">
                    @if($cover)
                        <img class="listing-card__cover" src="{{ $cover }}" alt="Copertina {{ $article->title }}" loading="lazy" decoding="async">
                    @endif
                    <time>{{ optional($article->published_at)->format('d.m.Y') ?: 'Archivio' }}</time>
                    <h2>{{ $article->title }}</h2>
                    <p>{{ \Illuminate\Support\Str::limit($body, 360) }}</p>
                </article>
            @endforeach
        </div>
        <div class="pagination-wrap">{{ $articles->links() }}</div>
    </div>
</section>
@endsection