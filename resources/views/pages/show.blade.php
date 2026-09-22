@extends('layouts.public')

@section('title', ($page->seo_title ?: $page->title) . ' | RingAnnouncer Valerio')
@section('description', $page->seo_description ?: \Illuminate\Support\Str::limit(trim(strip_tags($page->content ?? '')), 155))
@section('activeNav', match ($page->key) {
    'chi-sono' => 'Chi sono',
    'contatti' => 'Contatti',
    default => '',
})

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

    .contact-page {
        min-height: 100vh;
        padding: 138px 0 88px;
        background: #f8f6f1;
        color: #111;
    }

    .contact-layout {
        display: grid;
        grid-template-columns: minmax(0, .85fr) minmax(420px, 1fr);
        gap: 56px;
        align-items: start;
    }

    .contact-intro h1 {
        margin: 14px 0 18px;
        font: 900 clamp(58px, 7vw, 98px)/.82 "Bodoni MT Poster Compressed", "Bodoni 72 Smallcaps", "Bodoni MT", Didot, Georgia, "Times New Roman", serif;
        text-transform: uppercase;
        letter-spacing: 0;
    }

    .contact-intro h1 span {
        display: block;
        color: var(--gold);
    }

    .contact-intro p {
        max-width: 500px;
        margin: 0 0 24px;
        color: #2b251f;
        font: 20px/1.42 Georgia, "Times New Roman", serif;
    }

    .contact-details {
        display: grid;
        gap: 14px;
        margin-top: 32px;
        padding-top: 24px;
        border-top: 1px solid rgba(196, 146, 63, .32);
    }

    .contact-details span {
        display: block;
        color: var(--gold);
        font-family: "Arial Narrow", "Oswald", Arial, sans-serif;
        font-size: 12px;
        font-weight: 900;
        letter-spacing: .16em;
        text-transform: uppercase;
    }

    .contact-details a,
    .contact-details strong {
        color: #111;
        font: 700 18px/1.25 Georgia, "Times New Roman", serif;
    }

    .contact-card {
        border: 1px solid rgba(196, 146, 63, .35);
        background: #fff;
        padding: 32px;
        box-shadow: 0 24px 60px rgba(28, 20, 10, .08);
    }

    .contact-card__status {
        margin: 0 0 20px;
        border-left: 3px solid var(--gold);
        padding: 12px 14px;
        background: rgba(196, 146, 63, .1);
        color: #241c13;
        font: 700 15px/1.35 Georgia, "Times New Roman", serif;
    }

    .contact-form {
        display: grid;
        gap: 16px;
    }

    .contact-form__row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px;
    }

    .contact-form label {
        display: grid;
        gap: 8px;
        color: #1d1813;
        font-family: "Arial Narrow", "Oswald", Arial, sans-serif;
        font-size: 12px;
        font-weight: 900;
        letter-spacing: .12em;
        text-transform: uppercase;
    }

    .contact-form input,
    .contact-form textarea {
        width: 100%;
        border: 1px solid rgba(17, 17, 17, .18);
        background: #fbfaf7;
        color: #111;
        font: 16px/1.35 Georgia, "Times New Roman", serif;
        padding: 13px 14px;
        outline: none;
        transition: border-color .2s ease, box-shadow .2s ease;
    }

    .contact-form textarea {
        min-height: 150px;
        resize: vertical;
    }

    .contact-form input:focus,
    .contact-form textarea:focus {
        border-color: var(--gold);
        box-shadow: 0 0 0 3px rgba(196, 146, 63, .14);
    }

    .contact-form__error {
        color: #9f231f;
        font: 700 13px/1.3 Arial, Helvetica, sans-serif;
        letter-spacing: 0;
        text-transform: none;
    }

    .contact-form__hidden {
        position: absolute;
        left: -9999px;
        opacity: 0;
        pointer-events: none;
    }

    .contact-form .btn {
        width: fit-content;
        min-width: 190px;
        border: 0;
        cursor: pointer;
    }
    .story-page {
        min-height: 100vh;
        padding: 84px 0 0;
        background: #fff;
        color: #111;
    }

    .story-hero {
        position: relative;
        min-height: 420px;
        display: grid;
        align-items: center;
        overflow: hidden;
        background: #fff url("{{ asset('images/ringannouncer/about-page-hero-bg.webp') }}") center center / cover no-repeat;
    }

    .story-hero__content {
        max-width: 690px;
        padding: 34px 0 28px;
    }

    .story-hero h1 {
        margin: 13px 0 18px;
        font: 900 clamp(58px, 7.4vw, 104px)/.82 "Bodoni MT Poster Compressed", "Bodoni 72 Smallcaps", "Bodoni MT", Didot, Georgia, "Times New Roman", serif;
        text-transform: uppercase;
        letter-spacing: 0;
    }

    .story-hero h1 span {
        display: block;
        color: var(--gold);
    }

    .story-hero__rule {
        width: 78px;
        height: 2px;
        margin: 0 0 16px;
        background: var(--gold);
    }

    .story-hero__intro {
        max-width: 575px;
        margin: 0;
        font: 20px/1.34 Georgia, "Times New Roman", serif;
        color: #2b251f;
    }

    .story-content {
        padding-top: 46px;
        padding-bottom: 42px;
    }

    .story-content__bar {
        display: flex;
        align-items: end;
        justify-content: space-between;
        gap: 24px;
        margin: 0 0 30px;
        border-bottom: 1px solid rgba(196, 146, 63, .28);
        padding-bottom: 18px;
    }

    .story-content__bar strong {
        display: block;
        color: #111;
        font-family: "Arial Narrow", "Oswald", Arial, sans-serif;
        font-size: 13px;
        font-weight: 900;
        letter-spacing: .12em;
        text-transform: uppercase;
    }

    .story-content__bar p {
        margin: 0;
        color: #5f554a;
        font: 15px/1.35 Georgia, "Times New Roman", serif;
    }

    .story-content__body {
        max-width: 980px;
        margin: 0 auto;
        font: 20px/1.72 Georgia, "Times New Roman", serif;
        color: #231f1a;
        text-align: justify;
        text-justify: inter-word;
        hyphens: auto;
    }

    .story-content__body :is(p, ul, ol, blockquote, table, figure) {
        margin: 0 0 1.22em;
    }

    .story-content__body :is(h2, h3, h4) {
        margin: 1.35em 0 .55em;
        font-family: "Arial Narrow", "Oswald", Arial, sans-serif;
        font-weight: 900;
        letter-spacing: .06em;
        line-height: 1.05;
        text-transform: uppercase;
    }

    .story-content__body h2 { font-size: 28px; }
    .story-content__body h3 { font-size: 23px; }
    .story-content__body h4 { font-size: 19px; }

    .story-content__body a {
        color: #bf8b36;
        font-weight: 700;
        text-decoration: underline;
        text-underline-offset: 3px;
    }

    .story-footer-separator {
        position: relative;
        aspect-ratio: 2171 / 724;
        height: auto;
        margin-top: 0;
        overflow: hidden;
        background: #050607 url("{{ asset('images/ringannouncer/about-footer-separator.webp') }}") center center / cover no-repeat;
    }

    .story-footer-separator::before {
        content: "";
        position: absolute;
        inset: 0;
        background: linear-gradient(180deg, #fff 0%, rgba(255, 255, 255, .38) 18%, rgba(255, 255, 255, 0) 42%);
    }
    .story-content__body blockquote {
        border-left: 2px solid var(--gold);
        padding-left: 22px;
        color: #3a3026;
        font-style: italic;
    }

    .story-content__body img {
        max-width: 100%;
        height: auto;
    }

    @media(max-width: 720px) {
        .story-page {
            padding-top: 76px;
        }

        .story-hero {
            min-height: auto;
            padding: 38px 0 32px;
        }

        .story-hero h1 {
            font-size: 52px;
        }

        .story-hero__intro,
        .story-content__body {
            font-size: 18px;
        }

        .story-footer-separator {
            aspect-ratio: 2171 / 724;
            height: auto;
            margin-top: 0;
        }

        .contact-page {
            padding: 112px 0 56px;
        }

        .contact-layout,
        .contact-form__row {
            grid-template-columns: 1fr;
        }

        .contact-card {
            padding: 22px;
        }
        .story-content__bar {
            display: grid;
            justify-items: start;
        }
    }
</style>
@endpush

@section('content')
@if($page->key === 'chi-sono')
<section class="story-page" id="top">
    <div class="story-hero">
        <div class="wrap">
            <div class="story-hero__content">
                <div class="eyebrow">Biografia</div>
                <h1>Chi <span>sono</span></h1>
                <div class="story-hero__rule"></div>
                <p class="story-hero__intro">La storia, il percorso e la voce dietro il ring.</p>
            </div>
        </div>
    </div>

    <div class="wrap story-content">
        <div class="story-content__bar">
            <div>
                <strong>Valerio Lamanna</strong>
                <p>Ring announcer, speaker e presentatore per eventi sportivi.</p>
            </div>
        </div>

        @php
            $storyContent = preg_replace('/\R+/', '</p><p>', $page->content ?? '');
        @endphp
        <div class="story-content__body">
            {!! $storyContent !!}
        </div>
    </div>
    <div class="story-footer-separator" aria-hidden="true"></div>
</section>
@elseif($page->key === 'contatti')
<section class="contact-page" id="top">
    <div class="wrap contact-layout">
        <div class="contact-intro">
            <div class="eyebrow">Contatti</div>
            <h1>Scrivi <span>a Valerio</span></h1>
            <div class="story-hero__rule"></div>
            <div class="page-content__body">
                {!! $page->content !!}
            </div>
            <div class="contact-details">
                <div>
                    <span>Email</span>
                    <a href="mailto:{{ config('mail.contact_to') ?: config('mail.from.address') }}">{{ config('mail.contact_to') ?: config('mail.from.address') ?: 'info@ringannouncer.it' }}</a>
                </div>
                <div>
                    <span>Disponibilità</span>
                    <strong>Eventi sportivi, collaborazioni, serate e presentazioni.</strong>
                </div>
            </div>
        </div>

        <div class="contact-card">
            @if(session('contact_status'))
                <p class="contact-card__status">{{ session('contact_status') }}</p>
            @endif

            <form class="contact-form" method="post" action="{{ route('contact.store') }}">
                @csrf
                <label class="contact-form__hidden">Azienda
                    <input type="text" name="company" value="" tabindex="-1" autocomplete="off">
                </label>

                <div class="contact-form__row">
                    <label>Nome
                        <input type="text" name="name" value="{{ old('name') }}" required autocomplete="name">
                        @error('name')<span class="contact-form__error">{{ $message }}</span>@enderror
                    </label>
                    <label>Email
                        <input type="email" name="email" value="{{ old('email') }}" required autocomplete="email">
                        @error('email')<span class="contact-form__error">{{ $message }}</span>@enderror
                    </label>
                </div>

                <div class="contact-form__row">
                    <label>Telefono
                        <input type="text" name="phone" value="{{ old('phone') }}" autocomplete="tel">
                        @error('phone')<span class="contact-form__error">{{ $message }}</span>@enderror
                    </label>
                    <label>Tipo evento
                        <input type="text" name="event_type" value="{{ old('event_type') }}" placeholder="Boxe, gala, speakeraggio...">
                        @error('event_type')<span class="contact-form__error">{{ $message }}</span>@enderror
                    </label>
                </div>

                <label>Messaggio
                    <textarea name="message" required>{{ old('message') }}</textarea>
                    @error('message')<span class="contact-form__error">{{ $message }}</span>@enderror
                </label>

                <button class="btn" type="submit">Invia richiesta</button>
            </form>
        </div>
    </div>
</section>
@else
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
@endif
@endsection









