<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RingAnnouncer</title>
    <meta name="description" content="RingAnnouncer - eventi, gallery, video e curiosità dal mondo del ring.">
    <style>
        :root{--bg:#090909;--panel:#121212;--gold:#d4af37;--gold2:#f2d675;--text:#f7f4eb;--muted:#a7a7a7;--line:rgba(212,175,55,.22)}
        *{box-sizing:border-box}html{scroll-behavior:smooth}body{margin:0;background:var(--bg);color:var(--text);font-family:Inter,Arial,sans-serif;line-height:1.5}a{color:inherit;text-decoration:none}
        .nav{position:sticky;top:0;z-index:30;display:flex;justify-content:space-between;align-items:center;padding:18px 5vw;background:rgba(9,9,9,.86);backdrop-filter:blur(16px);border-bottom:1px solid var(--line)}
        .brand{font-weight:900;letter-spacing:.14em}.brand span{color:var(--gold)}.navlinks{display:flex;gap:24px;color:#ddd;font-size:.92rem}.navlinks a:hover{color:var(--gold2)}
        .hero{min-height:78vh;display:grid;place-items:center;padding:80px 5vw 50px;background:radial-gradient(circle at 70% 30%,rgba(212,175,55,.12),transparent 35%),linear-gradient(180deg,#090909,#0d0d0d)}
        .hero-inner{width:min(1200px,100%);display:grid;grid-template-columns:1.2fr .8fr;gap:60px;align-items:center}.eyebrow{color:var(--gold2);text-transform:uppercase;letter-spacing:.28em;font-size:.78rem}.hero h1{font-size:clamp(3.6rem,8vw,8rem);line-height:.9;margin:16px 0 24px;letter-spacing:-.05em}.hero h1 span{display:block;color:var(--gold)}.lead{font-size:1.15rem;color:#c9c9c9;max-width:650px}.cta{display:flex;gap:14px;margin-top:32px;flex-wrap:wrap}.btn{padding:13px 20px;border:1px solid var(--gold);border-radius:999px;font-weight:800}.btn.primary{background:var(--gold);color:#111}.btn:hover{transform:translateY(-1px)}
        .hero-card{border:1px solid var(--line);background:linear-gradient(145deg,rgba(255,255,255,.03),rgba(255,255,255,.01));padding:26px;border-radius:28px;box-shadow:0 30px 80px rgba(0,0,0,.35)}.hero-card .big{font-size:4rem;font-weight:900;color:var(--gold)}
        section{padding:88px 5vw}.wrap{width:min(1200px,100%);margin:auto}.section-head{display:flex;align-items:end;justify-content:space-between;gap:20px;margin-bottom:32px}.section-head h2{font-size:clamp(2rem,4vw,4rem);margin:0}.section-head p{max-width:520px;color:var(--muted)}
        .grid{display:grid;grid-template-columns:repeat(3,1fr);gap:18px}.card{background:var(--panel);border:1px solid rgba(255,255,255,.07);border-radius:22px;padding:22px;transition:.25s}.card:hover{border-color:var(--gold);transform:translateY(-3px)}.meta{color:var(--gold2);font-size:.82rem;text-transform:uppercase;letter-spacing:.1em}.card h3{margin:10px 0 8px;font-size:1.25rem}.muted{color:var(--muted)}
        .light{background:#f3f0e7;color:#111}.light .card{background:white;border-color:#ddd}.light .muted{color:#666}.light .meta{color:#8a6a00}
        .video-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:20px}.video{aspect-ratio:16/9;border-radius:22px;overflow:hidden;border:1px solid var(--line);background:#000}.video iframe{width:100%;height:100%;border:0}
        .socials{display:flex;flex-wrap:wrap;gap:12px}.social{padding:10px 16px;border:1px solid var(--line);border-radius:999px}.social:hover{background:var(--gold);color:#111}
        footer{padding:40px 5vw;border-top:1px solid var(--line);color:#888}.footer-in{width:min(1200px,100%);margin:auto;display:flex;justify-content:space-between;gap:20px;flex-wrap:wrap}
        @media(max-width:900px){.hero-inner{grid-template-columns:1fr}.hero-card{display:none}.grid,.video-grid{grid-template-columns:1fr}.navlinks{display:none}.hero{min-height:68vh}}
    </style>
</head>
<body>
<nav class="nav"><div class="brand">RING<span>ANNOUNCER</span></div><div class="navlinks"><a href="#eventi">Eventi</a><a href="#curiosita">Curiosità</a><a href="#gallery">Gallery</a><a href="#video">Video</a></div></nav>

<header class="hero">
    <div class="hero-inner">
        <div>
            <div class="eyebrow">Voice of the ring</div>
            <h1>THE RING <span>ANNOUNCER</span></h1>
            <p class="lead">Una presenza, una voce, un archivio di eventi e storie dal mondo del ring. Il nuovo sito parte da tutto il patrimonio storico già pubblicato e lo porta in una veste più forte, moderna e visiva.</p>
            <div class="cta"><a class="btn primary" href="#eventi">Prossimi eventi</a><a class="btn" href="#gallery">Esplora la gallery</a></div>
        </div>
        <div class="hero-card">
            <div class="meta">Archivio storico preservato</div>
            <div class="big">{{ \App\Models\Event::count() }}</div>
            <div class="muted">eventi migrati e pronti per il nuovo sito</div>
        </div>
    </div>
</header>

<section id="eventi"><div class="wrap"><div class="section-head"><div><div class="eyebrow">Calendario</div><h2>Prossimi eventi</h2></div><p>Qui compariranno solo gli appuntamenti futuri, gestiti dal pannello admin.</p></div><div class="grid">
@forelse($upcomingEvents as $event)
<div class="card"><div class="meta">{{ optional($event->event_date)->format('d M Y') }}</div><h3>{{ $event->title }}</h3><div class="muted">{{ $event->city ?: $event->venue ?: 'Dettagli in aggiornamento' }}</div></div>
@empty
<div class="card"><div class="meta">Calendario</div><h3>Nessun evento futuro inserito</h3><div class="muted">Appena Valerio inserirà il prossimo appuntamento, comparirà qui automaticamente.</div></div>
@endforelse
</div></div></section>

<section class="light" id="curiosita"><div class="wrap"><div class="section-head"><div><div class="eyebrow">Archivio editoriale</div><h2>Curiosità</h2></div><p>I contenuti storici caricati negli anni restano disponibili e possono essere valorizzati in una nuova forma editoriale.</p></div><div class="grid">
@foreach($articles as $article)
<div class="card"><div class="meta">{{ optional($article->published_at)->format('d/m/Y') }}</div><h3>{{ $article->title }}</h3><div class="muted">{{ \Illuminate\Support\Str::limit(strip_tags($article->content), 140) }}</div></div>
@endforeach
</div></div></section>

<section id="gallery"><div class="wrap"><div class="section-head"><div><div class="eyebrow">Immagini</div><h2>Gallery</h2></div><p>Le gallery legacy sono state migrate. Le fotografie migliori potranno poi essere sostituite con una selezione nuova ad alta qualità.</p></div><div class="grid">
@foreach($galleries as $gallery)
<div class="card"><div class="meta">{{ $gallery->media_count }} foto</div><h3>{{ $gallery->title }}</h3><div class="muted">{{ $gallery->description ?: 'Archivio fotografico RingAnnouncer' }}</div></div>
@endforeach
</div></div></section>

<section id="video" class="light"><div class="wrap"><div class="section-head"><div><div class="eyebrow">YouTube</div><h2>Video dal ring</h2></div><p>I video storici sono già stati normalizzati dal vecchio Drupal e possono essere gestiti singolarmente.</p></div><div class="video-grid">
@foreach($videos as $video)
<div class="video"><iframe loading="lazy" src="https://www.youtube-nocookie.com/embed/{{ $video->youtube_id }}" title="{{ $video->title }}" allowfullscreen></iframe></div>
@endforeach
</div></div></section>

<section><div class="wrap"><div class="section-head"><div><div class="eyebrow">Seguimi</div><h2>Social & Partner</h2></div></div><div class="socials">@foreach($socialLinks as $social)<a class="social" href="{{ $social->url }}" target="_blank" rel="noopener">{{ ucfirst($social->platform) }}{{ $social->username ? ' · '.$social->username : '' }}</a>@endforeach</div></div></section>

<footer><div class="footer-in"><strong>RINGANNOUNCER</strong><span>Nuovo progetto Laravel · nero / bianco / oro</span></div></footer>
</body>
</html>
