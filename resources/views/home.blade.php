<!DOCTYPE html>
<html lang="it">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>RingAnnouncer Valerio</title>
<meta name="description" content="RingAnnouncer Valerio - una voce oltre il ring.">
<link rel="canonical" href="{{ url('/') }}">
<meta property="og:type" content="website">
<meta property="og:locale" content="it_IT">
<meta property="og:title" content="RingAnnouncer Valerio">
<meta property="og:description" content="RingAnnouncer Valerio - una voce oltre il ring.">
<meta property="og:url" content="{{ url('/') }}">
<meta property="og:image" content="{{ asset(file_exists(public_path('images/ringannouncer/hero-final-user-white-edge.webp')) ? 'images/ringannouncer/hero-final-user-white-edge.webp' : 'images/ringannouncer/hero-final-user-white-edge.png') }}">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="RingAnnouncer Valerio">
<meta name="twitter:description" content="RingAnnouncer Valerio - una voce oltre il ring.">
<meta name="twitter:image" content="{{ asset(file_exists(public_path('images/ringannouncer/hero-final-user-white-edge.webp')) ? 'images/ringannouncer/hero-final-user-white-edge.webp' : 'images/ringannouncer/hero-final-user-white-edge.png') }}">
<script type="application/ld+json">
{!! json_encode([
    '@' . 'context' => 'https://schema.org',
    '@type' => 'Person',
    'name' => 'Valerio Lamanna',
    'jobTitle' => 'Ring announcer, speaker e presentatore',
    'description' => 'Ring announcer, speaker e presentatore specializzato in eventi di boxe, kickboxing, muay thai e MMA.',
    'url' => url('/'),
    'image' => asset(file_exists(public_path('images/ringannouncer/hero-final-user-white-edge.webp')) ? 'images/ringannouncer/hero-final-user-white-edge.webp' : 'images/ringannouncer/hero-final-user-white-edge.png'),
    'brand' => [
        '@type' => 'Brand',
        'name' => 'RingAnnouncer Valerio Lamanna',
        'url' => url('/'),
    ],
    'knowsAbout' => ['Boxe', 'Kickboxing', 'Muay Thai', 'MMA', 'Eventi sportivi', 'Ring announcing'],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>
<link rel="preload" as="image" href="{{ asset(file_exists(public_path('images/ringannouncer/hero-final-user-white-edge.webp')) ? 'images/ringannouncer/hero-final-user-white-edge.webp' : 'images/ringannouncer/hero-final-user-white-edge.png') }}" fetchpriority="high">
<link rel="preload" as="style" href="{{ asset('css/ringannouncer-home.css') }}?v={{ filemtime(public_path('css/ringannouncer-home.css')) }}">
<link rel="stylesheet" href="{{ asset('css/ringannouncer-home.css') }}?v={{ filemtime(public_path('css/ringannouncer-home.css')) }}">
<link rel="stylesheet" href="{{ asset('css/ringannouncer-events-calendar.css') }}?v={{ filemtime(public_path('css/ringannouncer-events-calendar.css')) }}">
</head>
<body>
@php
    $imageAsset = function (string $path) {
        $webp = preg_replace('/\.(png|jpe?g)$/i', '.webp', $path);

        return $webp && file_exists(public_path($webp))
            ? asset($webp)
            : asset($path);
    };

    $assetOrUploaded = function (?string $path, string $fallback) use ($imageAsset) {
        if (blank($path)) {
            return $imageAsset($fallback);
        }
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://') || str_starts_with($path, '/')) {
            return $path;
        }
        if (str_starts_with($path, 'images/')) {
            return $imageAsset($path);
        }
        return \Illuminate\Support\Facades\Storage::url($path);
    };

    $s = $settings;
    $partnerLogoUrl = fn (?string $path) => blank($path) ? null : $assetOrUploaded($path, $path);
    $images = [
        'hero' => $imageAsset('images/ringannouncer/hero-final-user-white-edge.png'),
        'eventsBg' => $assetOrUploaded($s?->events_background_image, 'images/ringannouncer/mockup-slices/section-bg-light-clean.png'),
        'galleryBg' => $imageAsset('images/ringannouncer/gallery-bg-user-gold.png'),
        'bio' => $imageAsset('images/ringannouncer/bio-user-valerio.png'),
        'bioBg' => $assetOrUploaded($s?->bio_background_image, 'images/ringannouncer/mockup-slices/bio-light-clean.png'),
        'cta' => $assetOrUploaded($s?->cta_background_image, 'images/ringannouncer/mockup-slices/cta-bg-clean.png'),
        'footerBg' => $assetOrUploaded($s?->footer_background_image, 'images/ringannouncer/mockup-slices/section-bg-dark-clean.png'),
        'event' => $imageAsset('images/ringannouncer/mockup-slices/event-card-1-clean.png'),
        'portrait' => $imageAsset('images/ringannouncer/mockup-slices/event-card-2-clean.png'),
        'ring' => $imageAsset('images/ringannouncer/mockup-slices/event-card-3-clean.png'),
    ];

    $eventsSource = ($upcomingEvents->isNotEmpty() ? $upcomingEvents : $recentEvents)->take(12)->values();
    $fallbackEvents = collect([
        ['title' => 'Milano Boxing Night', 'date' => '18', 'month' => 'GEN', 'date_iso' => null, 'venue' => 'Allianz Cloud, Milano', 'type' => 'Boxe Professionistica', 'description' => 'Dettagli evento in aggiornamento.', 'image' => $images['event']],
        ['title' => 'Italian Muay Thai League', 'date' => '07', 'month' => 'FEB', 'date_iso' => null, 'venue' => 'Palazzetto dello Sport, Roma', 'type' => 'Muay Thai', 'description' => 'Dettagli evento in aggiornamento.', 'image' => $images['portrait']],
        ['title' => 'Fighting Spirit', 'date' => '22', 'month' => 'MAR', 'date_iso' => null, 'venue' => 'PalaTrento, Trento', 'type' => 'MMA', 'description' => 'Dettagli evento in aggiornamento.', 'image' => $images['ring']],
        ['title' => 'Venice Combat', 'date' => '12', 'month' => 'APR', 'date_iso' => null, 'venue' => 'PalaSport Taliercio, Venezia', 'type' => 'Kickboxing', 'description' => 'Dettagli evento in aggiornamento.', 'image' => $images['ring']],
    ]);
    $events = $eventsSource->isNotEmpty()
        ? $eventsSource->map(fn ($event, $index) => [
            'title' => $event->title,
            'date' => optional($event->event_date)->format('d') ?: '00',
            'month' => optional($event->event_date)->translatedFormat('M') ? strtoupper(optional($event->event_date)->translatedFormat('M')) : 'TBA',
            'date_iso' => optional($event->event_date)->toDateString(),
            'venue' => $event->venue ?: $event->city ?: 'Location da definire',
            'type' => $event->weight_category ?: 'Evento sportivo',
            'description' => \Illuminate\Support\Str::limit(trim(strip_tags($event->description ?: 'Dettagli evento in aggiornamento.')), 900),
            'image' => $event->cover_image ? $assetOrUploaded($event->cover_image, 'images/ringannouncer/event-boxing.png') : [$images['event'], $images['portrait'], $images['ring'], $imageAsset('images/ringannouncer/mockup-slices/event-card-4-clean.png')][$index % 4],
        ])
        : $fallbackEvents;
    $eventsByDate = collect($calendarEvents ?? [])->filter(fn ($event) => filled($event['date'] ?? null))->groupBy('date');
    $calendarBase = now()->startOfMonth();
    $calendarStart = $calendarBase->copy()->startOfWeek(\Carbon\CarbonInterface::MONDAY);
    $calendarDays = collect(range(0, 41))->map(fn ($offset) => $calendarStart->copy()->addDays($offset));
    $calendarPayload = collect($calendarEvents ?? [])->values();
    $galleryImages = collect([$imageAsset('images/ringannouncer/gallery-main-user.png'), $imageAsset('images/ringannouncer/gallery-thumb-1-user-card.png'), $imageAsset('images/ringannouncer/gallery-thumb-2-user-card.png'), $imageAsset('images/ringannouncer/gallery-thumb-3-user-card.png'), $imageAsset('images/ringannouncer/gallery-thumb-4-user-card.png')]);
    $ctaTitle = $s?->cta_title ?? 'ATTESA. ADRENALINA. SPETTACOLO.';
    $navItems = collect([
        ['label' => 'Home', 'href' => '#home'],
        ['label' => 'Chi sono', 'href' => '#bio'],
        ['label' => 'Eventi', 'href' => '#eventi'],
        ['label' => 'Gallery', 'href' => '#gallery'],
        ['label' => 'Video', 'href' => '#video', 'show' => $videos->isNotEmpty()],
        ['label' => 'Curiosità', 'href' => '#curiosita', 'show' => $articles->isNotEmpty()],
        ['label' => 'Contatti', 'href' => '#contatti'],
    ])->filter(fn ($item) => $item['show'] ?? true);
@endphp
<div class="site-frame">
<header id="home" class="hero">
    <div class="hero-bg"><img src="{{ $images['hero'] }}" alt="Valerio Lamanna davanti al ring durante un evento" width="1891" height="831" fetchpriority="high" loading="eager"></div>
    <div class="topbar"><div class="wrap"><a class="brand" href="#home"><img src="{{ $imageAsset('images/ringannouncer/logo-valerio-header.png') }}" alt="RingAnnouncer Valerio Lamanna" width="1825" height="355" loading="eager"></a><x-site-nav :items="$navItems" /><x-social-icons /><a class="btn" href="#eventi">Prossimi eventi</a><button class="menu-toggle" type="button" aria-label="Apri menu" aria-expanded="false"><span></span><span></span><span></span></button></div></div>
    <div class="wrap hero-inner"><div><div class="eyebrow">{{ $s?->hero_eyebrow ?? 'BOXE · DETTAGLIO · SPETTACOLO' }}</div><h1>{{ $s?->hero_line_1 ?? 'Una voce' }}<span>{{ $s?->hero_line_2 ?? 'oltre' }}</span><span>{{ $s?->hero_line_3 ?? 'il ring' }}</span></h1><div class="rule"></div><p>{{ $s?->hero_intro ?? 'Eventi, match, persone. Ogni grande spettacolo inizia con una grande voce.' }}</p><div class="hero-actions"><a class="btn" href="{{ $s?->hero_cta_url ?? '#bio' }}">{{ $s?->hero_cta_text ?? 'Scopri chi sono' }}</a><a class="play-link" href="{{ $s?->hero_video_url ?? '#video' }}"><span class="play">▶</span>{{ $s?->hero_video_text ?? 'Guarda il video' }}</a></div></div></div>
    <div class="hero-note">Voce<br>emozione<br>attesa<br>adrenalina</div><div class="signature"><p>{{ $s?->hero_side_line_1 ?? 'RISPETTO' }}<br>{{ $s?->hero_side_line_2 ?? 'PASSIONE' }}<br>{{ $s?->hero_side_line_3 ?? 'PROFESSIONALITÀ' }}</p></div>
</header>
<main>
<section id="eventi" class="events" style="background-image:url('{{ $images['eventsBg'] }}')"><div class="wrap events-grid"><div class="intro"><div class="mini">{{ $s?->events_eyebrow ?? 'Next' }}</div><h2>{!! nl2br(e($s?->events_title ?? "Prossimi\neventi")) !!}</h2><p>{{ $s?->events_intro ?? 'Vivi dal vivo l’energia dei grandi match. Scopri dove sarò il prossimo.' }}</p><a class="text-link" href="{{ route('events.index') }}">Vai al calendario</a></div><div class="mini-calendar" data-calendar data-events='@json($calendarPayload)' aria-label="Calendario eventi {{ $calendarBase->translatedFormat('F Y') }}"><div class="mini-calendar__bar"><button type="button" data-calendar-prev aria-label="Mese precedente">‹</button><button type="button" data-calendar-today>Oggi</button><button type="button" data-calendar-next aria-label="Mese successivo">›</button></div><div class="mini-calendar__head"><span data-calendar-month>{{ $calendarBase->translatedFormat('F') }}</span><strong data-calendar-year>{{ $calendarBase->format('Y') }}</strong></div><div class="mini-calendar__week"><span>L</span><span>M</span><span>M</span><span>G</span><span>V</span><span>S</span><span>D</span></div><div class="mini-calendar__grid" data-calendar-grid>@foreach($calendarDays as $day)@php($dayEvents = $eventsByDate->get($day->toDateString(), collect()))<span class="mini-calendar__day {{ $dayEvents->isNotEmpty() ? 'has-event' : '' }} {{ $day->month === $calendarBase->month ? '' : 'is-muted' }}" @if($dayEvents->isNotEmpty()) title="{{ $dayEvents->map(fn ($event) => filled($event['venue'] ?? null) ? $event['title'].' · '.$event['venue'] : $event['title'])->implode(' / ') }}" @endif><span>{{ $day->format('j') }}</span></span>@endforeach</div></div><div class="carousel events-carousel"><div class="carousel-top"><span></span><x-carousel-controls previous-label="Eventi precedenti" next-label="Eventi successivi" /></div><div class="carousel-track">@foreach($events as $event)<article class="event-card modal-trigger" role="button" tabindex="0" data-modal-target="event-modal-{{ $loop->iteration }}"><img src="{{ $event['image'] }}" alt="{{ $event['title'] }}" loading="lazy" decoding="async"><div class="date"><strong>{{ $event['date'] }}</strong><span>{{ $event['month'] }}</span></div><div class="body"><h3>{{ $event['title'] }}</h3><p class="event-meta"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2a7 7 0 0 0-7 7c0 5.2 7 13 7 13s7-7.8 7-13a7 7 0 0 0-7-7Zm0 9.6A2.6 2.6 0 1 1 12 6.4a2.6 2.6 0 0 1 0 5.2Z"/></svg><span>{{ $event['venue'] }}</span></p><p class="event-meta"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 3 4 8v8l8 5 8-5V8l-8-5Zm0 2.4 5.6 3.5L12 12.3 6.4 8.9 12 5.4Zm-6 5.7 5 3v4.2l-5-3.1v-4.1Zm12 0v4.1l-5 3.1v-4.2l5-3Z"/></svg><span>{{ $event['type'] }}</span></p></div><span class="go">›</span></article>@endforeach</div></div></div>@foreach($events as $event)<div class="content-modal" id="event-modal-{{ $loop->iteration }}" hidden><div class="content-modal__backdrop" data-modal-close></div><article class="content-modal__panel" role="dialog" aria-modal="true" aria-labelledby="event-title-{{ $loop->iteration }}"><button class="content-modal__close" type="button" data-modal-close aria-label="Chiudi">×</button><time class="content-modal__eyebrow">{{ $event['date'] }} {{ $event['month'] }}</time><h3 id="event-title-{{ $loop->iteration }}">{{ $event['title'] }}</h3><p><strong>{{ $event['venue'] }}</strong></p><p>{{ $event['description'] ?? 'Dettagli evento in aggiornamento.' }}</p><a class="btn" href="{{ route('events.index') }}">Lista completa</a></article></div>@endforeach</section>
<section id="gallery" class="gallery" style="background-image:url('{{ $images['galleryBg'] }}')"><div class="wrap gallery-layout"><div><div class="eyebrow">{{ $s?->gallery_eyebrow ?? 'Gallery' }}</div><h2>{!! nl2br(e($s?->gallery_title ?? "Momenti\nche restano")) !!}</h2><p>{{ $s?->gallery_intro ?? 'Immagini, backstage ed emozioni da dentro e fuori dal ring.' }}</p><a class="btn" href="#gallery">Vai alla gallery</a></div><div class="gallery-carousel carousel" data-gallery><div class="carousel-top"><span></span><x-carousel-controls previous-label="Immagine precedente" next-label="Immagine successiva" /></div><div class="gallery-grid">@foreach($galleryImages as $image)<figure class="gallery-item {{ $loop->first ? 'big' : '' }}" data-gallery-item data-gallery-modal-image="{{ $image }}" data-gallery-modal-title="Momento dal ring RingAnnouncer {{ $loop->iteration }}" role="button" tabindex="0"><img src="{{ $image }}" alt="Momento dal ring RingAnnouncer {{ $loop->iteration }}" loading="lazy" decoding="async"></figure>@endforeach</div><div class="pager" data-gallery-pager>@foreach($galleryImages as $image)<button class="pager-num {{ $loop->first ? 'is-active' : '' }}" type="button" data-gallery-page="{{ $loop->index }}">{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</button>@endforeach</div></div></div><div class="gallery-modal" data-gallery-modal hidden><div class="gallery-modal__backdrop" data-gallery-close></div><article class="gallery-modal__panel" role="dialog" aria-modal="true" aria-labelledby="gallery-modal-title"><button class="content-modal__close" type="button" data-gallery-close aria-label="Chiudi">×</button><h3 id="gallery-modal-title" data-gallery-title>Gallery</h3><img data-gallery-image src="" alt=""></article></div></section>
@if($videos->isNotEmpty())<section id="video" class="video-showcase" style="background-image:url('{{ $images['bioBg'] }}')"><div class="wrap video-carousel carousel"><div class="video-head carousel-top"><div><div class="eyebrow">Video</div><h2>Dentro<br>il ring</h2></div><p>Una selezione di momenti, ingressi e serate raccontate dalla voce di Valerio.</p><x-carousel-controls previous-label="Video precedenti" next-label="Video successivi" /></div><div class="video-slider carousel-track">@foreach($videos as $video)<button class="video-card" type="button" data-video-id="{{ $video->youtube_id }}" data-video-title="{{ $video->title }}" aria-label="Guarda {{ $video->title }}"><img src="{{ $video->thumbnail ?: 'https://i.ytimg.com/vi/'.$video->youtube_id.'/hqdefault.jpg' }}" alt="{{ $video->title }}" loading="lazy" decoding="async"><span class="video-play">▶</span><span class="video-title">{{ $video->title }}</span></button>@endforeach</div></div><div class="video-modal" data-video-modal hidden><div class="video-modal__backdrop" data-video-close></div><article class="video-modal__panel" role="dialog" aria-modal="true" aria-labelledby="video-modal-title"><button class="content-modal__close" type="button" data-video-close aria-label="Chiudi">×</button><h3 id="video-modal-title" data-video-title>Video</h3><div class="video-modal__frame"><iframe data-video-frame title="Video RingAnnouncer Valerio Lamanna" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe></div></article></div></section>@endif
@if($articles->isNotEmpty())<section id="curiosita" class="curiosita" style="background-image:url('{{ $imageAsset('images/ringannouncer/curiosita-bg-ring-gold.png') }}')"><div class="wrap curiosity-layout"><div class="curiosity-head"><div class="eyebrow">Curiosità</div><h2>Storie<br>dal ring</h2><p>Appunti, ricordi e momenti raccolti in venti anni di eventi.</p><a class="btn" href="{{ route('articles.index') }}">Vai alle curiosità</a></div><div class="carousel curiosity-carousel"><div class="carousel-top"><span></span><x-carousel-controls previous-label="Curiosità precedenti" next-label="Curiosità successive" /></div><div class="curiosity-list carousel-track">@foreach($articles as $article)<article class="curiosity-card modal-trigger" role="button" tabindex="0" data-modal-target="article-modal-{{ $loop->iteration }}"><time>{{ optional($article->published_at)->format('Y') }}</time><h3>{{ $article->title }}</h3><span>Leggi</span></article>@endforeach</div></div></div>@foreach($articles as $article)<div class="content-modal" id="article-modal-{{ $loop->iteration }}" hidden><div class="content-modal__backdrop" data-modal-close></div><article class="content-modal__panel" role="dialog" aria-modal="true" aria-labelledby="article-title-{{ $loop->iteration }}"><button class="content-modal__close" type="button" data-modal-close aria-label="Chiudi">×</button><time class="content-modal__eyebrow">{{ optional($article->published_at)->format('d.m.Y') ?: 'Archivio' }}</time><h3 id="article-title-{{ $loop->iteration }}">{{ $article->title }}</h3><p>{{ \Illuminate\Support\Str::limit(trim(strip_tags($article->excerpt ?: $article->content ?: 'Contenuto in aggiornamento.')), 1000) }}</p><a class="btn" href="{{ route('articles.index') }}">Lista completa</a></article></div>@endforeach</section>@endif
<section id="bio" class="bio" style="background-image:url('{{ $images['bioBg'] }}')"><div class="wrap bio-grid"><div class="bio-copy"><div class="eyebrow">{{ $s?->bio_eyebrow ?? 'Biografia' }}</div><h2>{{ $s?->bio_title ?? 'Valerio' }}</h2><p>{{ $s?->bio_body ?? 'Ring announcer, speaker e presentatore specializzato in eventi di boxe, kickboxing, muay thai e MMA. Una passione per lo sport da sempre, una voce al servizio delle emozioni.' }}</p><a class="btn light" href="#contatti">Scopri di più</a></div><div class="bio-img"><img src="{{ $images['bio'] }}" alt="Valerio Lamanna con microfono sul ring" width="1774" height="887" loading="lazy" decoding="async"></div><div class="quote"><blockquote>{{ $s?->bio_quote ?? 'Creare attesa significa trasformare pochi secondi in emozione. È lì che comincia lo spettacolo' }}</blockquote><div class="sig"><img src="{{ $imageAsset('images/ringannouncer/signature-valerio-lamanna.png') }}" alt="Firma Valerio Lamanna" width="1852" height="849" loading="lazy" decoding="async"></div></div><aside class="stats"><x-bio-stat icon="▣" :value="$bioStats['events'] ?? '≈500'" :label="$s?->stat_events_label ?? 'EVENTI ANNUNCIATI'" /><x-bio-stat icon="♚" :value="$bioStats['years'] ?? '20'" :label="$s?->stat_cities_label ?? 'ANNI SUL RING'" /><x-bio-stat icon="♕" :value="$bioStats['disciplines'] ?? '4'" :label="$s?->stat_disciplines_label ?? 'DISCIPLINE DA COMBATTIMENTO'" /><x-bio-stat icon="★" :value="$bioStats['startYear'] ?? '2004'" :label="$s?->stat_unique_label ?? 'L\'INIZIO'" /></aside></div></section>@if($partners->isNotEmpty())<div class="partners-separator" aria-hidden="true"></div><section class="partners" style="background-image:url('{{ $images['bioBg'] }}')"><div class="wrap partners-row"><div class="partners-label">Partner</div><div class="partners-logos">@foreach($partners as $partner)@php($logo = $partnerLogoUrl($partner->logo))@if($logo)<a class="partner-logo" href="{{ $partner->url ?: '#' }}" @if($partner->url) target="_blank" rel="noopener" @endif aria-label="{{ $partner->name }}"><img src="{{ $logo }}" alt="Logo {{ $partner->name }}" loading="lazy" decoding="async"></a>@endif @endforeach</div></div></section>@endif
<section id="contatti" class="cta"><div class="cta-bg"><img src="{{ $images['cta'] }}" alt="Corde del ring illuminate" loading="lazy" decoding="async"></div><div class="wrap cta-inner"><h2>{!! nl2br(e(str_replace(' THE ', "\nTHE ", $ctaTitle))) !!}</h2><p><strong>Contattami</strong>{{ $s?->cta_text ?? 'Per eventi, collaborazioni e informazioni' }}</p><a class="btn" href="{{ $s?->cta_button_url ?? 'mailto:info@ringannouncer.it' }}">{{ $s?->cta_button_text ?? 'Scrivimi' }}</a></div></section>
</main><footer class="footer" style="background-image:url('{{ $images['footerBg'] }}')"><div class="wrap footer-grid"><a class="brand" href="#home"><img src="{{ $imageAsset('images/ringannouncer/logo-valerio-header.png') }}" alt="RingAnnouncer Valerio Lamanna" width="1825" height="355" loading="lazy" decoding="async"></a><x-site-nav :items="$navItems" /><x-social-icons /><div class="tag">{{ $s?->footer_tagline ?? 'Preparazione. Dettaglio. Spettacolo.' }}</div><a class="up" href="#home">↑</a><div class="copy">© {{ date('Y') }} RingAnnouncer. Tutti i diritti riservati.</div><a class="credit" href="https://byoursite.com" target="_blank" rel="noopener"><span>Website by</span> byoursite.com</a></div></footer>
</div><script src="{{ asset('js/ringannouncer-home.js') }}?v={{ filemtime(public_path('js/ringannouncer-home.js')) }}" defer></script>
</body>
</html>










