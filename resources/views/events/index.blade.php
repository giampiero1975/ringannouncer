@extends('layouts.public')

@section('title', 'Eventi | RingAnnouncer Valerio')
@section('description', 'Calendario eventi RingAnnouncer Valerio Lamanna.')
@section('activeNav', 'Eventi')

@section('content')
<section class="listing-page" id="top">
    <div class="wrap">
        <header class="listing-head">
            <div>
                <div class="eyebrow">Calendario</div>
                <h1>Eventi</h1>
            </div>
            <a class="btn" href="{{ route('home') }}#eventi">Torna alla home</a>
        </header>
        <div class="listing-grid">
            @foreach($events as $event)
                <article class="listing-card">
                    <time>{{ optional($event->event_date)->format('d.m.Y') ?: 'Data da definire' }}</time>
                    <h2>{{ $event->title }}</h2>
                    <p>{{ $event->venue ?: $event->city ?: 'Location da definire' }}</p>
                    @if($event->description)
                        <p>{{ \Illuminate\Support\Str::limit(trim(strip_tags($event->description)), 220) }}</p>
                    @endif
                </article>
            @endforeach
        </div>
        <div class="pagination-wrap">{{ $events->links() }}</div>
    </div>
</section>
@endsection
