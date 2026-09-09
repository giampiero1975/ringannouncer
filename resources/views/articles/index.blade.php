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
                <article class="listing-card">
                    <time>{{ optional($article->published_at)->format('d.m.Y') ?: 'Archivio' }}</time>
                    <h2>{{ $article->title }}</h2>
                    <p>{{ \Illuminate\Support\Str::limit(trim(strip_tags($article->excerpt ?: $article->content ?: 'Contenuto in aggiornamento.')), 240) }}</p>
                </article>
            @endforeach
        </div>
        <div class="pagination-wrap">{{ $articles->links() }}</div>
    </div>
</section>
@endsection
