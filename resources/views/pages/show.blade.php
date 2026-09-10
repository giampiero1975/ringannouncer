@extends('layouts.public')

@section('title', ($page->seo_title ?: $page->title) . ' | RingAnnouncer Valerio')
@section('description', $page->seo_description ?: \Illuminate\Support\Str::limit(trim(strip_tags($page->content ?? '')), 155))
@section('activeNav', $page->key === 'chi-sono' ? 'Chi sono' : ($page->key === 'video-37' ? 'Video' : ''))

@push('styles')
<style>
    .page-content {
        min-height: 520px;
        padding: 138px 0 72px;
        background: #f4efe5;
        color: #111;
    }

    .page-content__head {
        max-width: 820px;
        margin-bottom: 32px;
    }

    .page-content h1 {
        margin: 12px 0 0;
        font: 900 54px/.84 "Bodoni MT Poster Compressed", "Bodoni 72 Smallcaps", "Bodoni MT", Didot, Georgia, "Times New Roman", serif;
        letter-spacing: -.018em;
        text-transform: uppercase;
    }

    .page-content__body {
        max-width: 920px;
        font: 17px/1.62 Georgia, "Times New Roman", serif;
    }

    .page-content__body :is(p, ul, ol, blockquote) {
        margin: 0 0 1.15em;
    }

    .page-content__body a {
        color: #bf8b36;
        font-weight: 700;
        text-decoration: underline;
        text-underline-offset: 3px;
    }
</style>
@endpush

@section('content')
<section class="page-content" id="top">
    <div class="wrap">
        <header class="page-content__head">
            <div class="eyebrow">Pagina</div>
            <h1>{{ $page->title }}</h1>
        </header>

        <div class="page-content__body">
            {!! $page->content !!}
        </div>
    </div>
</section>
@endsection
