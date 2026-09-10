@php
    $settings = \App\Models\SiteSetting::query()->first();
    $activeNav = trim($__env->yieldContent('activeNav', ''));
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
    $pageLinks = \App\Models\Page::query()
        ->published()
        ->whereIn('key', ['chi-sono', 'video-37', 'contatti'])
        ->pluck('key')
        ->mapWithKeys(fn (string $key) => [$key => route('pages.show', $key)]);
    $navItems = collect([
        ['label' => 'Home', 'href' => route('home') . '#home'],
        ['label' => 'Chi sono', 'href' => $pageLinks['chi-sono'] ?? route('home') . '#bio'],
        ['label' => 'Eventi', 'href' => route('home') . '#eventi'],
        ['label' => 'Gallery', 'href' => route('home') . '#gallery'],
        ['label' => 'Video', 'href' => $pageLinks['video-37'] ?? route('home') . '#video', 'show' => \App\Models\Video::where('is_published', true)->exists() || isset($pageLinks['video-37'])],
        ['label' => 'Curiosità', 'href' => route('home') . '#curiosita', 'show' => \App\Models\Article::where('is_published', true)->exists()],
        ['label' => 'Contatti', 'href' => $pageLinks['contatti'] ?? route('home') . '#contatti'],
    ])->filter(fn ($item) => $item['show'] ?? true)
        ->map(fn ($item) => array_merge($item, ['active' => $activeNav === $item['label']]))
        ->values();
    $footerBg = $assetOrUploaded($settings?->footer_background_image, 'images/ringannouncer/mockup-slices/section-bg-dark-clean.png');
@endphp
<!DOCTYPE html>
<html lang="it">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'RingAnnouncer Valerio')</title>
<meta name="description" content="@yield('description', 'RingAnnouncer Valerio - una voce oltre il ring.')">
<link rel="canonical" href="{{ url()->current() }}">
<link rel="preload" as="style" href="{{ asset('css/ringannouncer-home.css') }}?v={{ filemtime(public_path('css/ringannouncer-home.css')) }}">
<link rel="stylesheet" href="{{ asset('css/ringannouncer-home.css') }}?v={{ filemtime(public_path('css/ringannouncer-home.css')) }}">
@stack('styles')
</head>
<body>
<div class="site-frame">
    <header class="page-topbar topbar">
        <div class="wrap">
            <a class="brand" href="{{ route('home') }}#home">
                <img src="{{ $imageAsset('images/ringannouncer/logo-valerio-header.png') }}" alt="RingAnnouncer Valerio Lamanna" width="1825" height="355" loading="eager">
            </a>
            <x-site-nav :items="$navItems" />
            <x-social-icons />
            <a class="btn" href="{{ route('home') }}#eventi">Prossimi eventi</a>
            <button class="menu-toggle" type="button" aria-label="Apri menu" aria-expanded="false"><span></span><span></span><span></span></button>
        </div>
    </header>
    <main>
        @yield('content')
    </main>
    <footer class="footer" style="background-image:url('{{ $footerBg }}')">
        <div class="wrap footer-grid">
            <a class="brand" href="{{ route('home') }}#home">
                <img src="{{ $imageAsset('images/ringannouncer/logo-valerio-header.png') }}" alt="RingAnnouncer Valerio Lamanna" width="1825" height="355" loading="lazy" decoding="async">
            </a>
            <x-site-nav :items="$navItems" />
            <x-social-icons />
            <div class="tag">{{ $settings?->footer_tagline ?? 'Preparazione. Dettaglio. Spettacolo.' }}</div>
            <a class="up" href="#top">↑</a>
            <div class="copy">© {{ date('Y') }} RingAnnouncer. Tutti i diritti riservati.</div>
            <a class="credit" href="https://byoursite.com" target="_blank" rel="noopener"><span>Website by</span> byoursite.com</a>
        </div>
    </footer>
</div>
<script src="{{ asset('js/ringannouncer-home.js') }}?v={{ filemtime(public_path('js/ringannouncer-home.js')) }}" defer></script>
@stack('scripts')
</body>
</html>
