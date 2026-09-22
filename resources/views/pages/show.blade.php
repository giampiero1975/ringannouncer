@extends('layouts.public')

@section('title', ($page->seo_title ?: $page->title) . ' | RingAnnouncer Valerio')
@section('description', $page->seo_description ?: \Illuminate\Support\Str::limit(trim(strip_tags($page->content ?? '')), 155))
@section('activeNav', match ($page->key) {
    'chi-sono' => 'Chi sono',
    'contatti' => 'Contatti',
    default => '',
})

@push('styles')
<link rel="stylesheet" href="{{ asset('css/ringannouncer-pages.css') }}?v={{ filemtime(public_path('css/ringannouncer-pages.css')) }}">
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
    <x-page-footer-separator />
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
    <x-page-footer-separator />
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
    <x-page-footer-separator />
</section>
@endif
@endsection









