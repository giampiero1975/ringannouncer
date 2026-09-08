# Migliorie Homepage RingAnnouncer

## Decisione Di Base

Per la hero conviene usare un approccio ibrido:

- immagine unica per foto, bordo inferiore, fumo, firma decorativa e dettagli che devono combaciare al pixel;
- HTML/CSS per titolo principale, menu, bottoni, social e testi importanti;
- niente overlay complessi sopra la hero se l'effetto e' gia dentro l'immagine.

Questo evita di perdere tempo con allineamenti fragili, trasparenze, gradienti e differenze tra browser.

## Hero

Stato attuale approvato:

- immagine hero: `public/images/ringannouncer/hero-final-user-white-edge.png`;
- overlay scuro disattivato: `.hero-bg:after{content:none}`;
- bordo inferiore incorporato direttamente nell'immagine;
- blocco firma/testi alzato rispetto alla posizione precedente.

Da valutare alla fine:

- se alleggerire leggermente il blocco sinistro;
- se ridurre la presenza della firma `Valerio Lamanna`;
- se mantenere firma/testi laterali in HTML oppure inserirli direttamente nella hero finale.

## Cosa Conviene Fare In Immagine

Meglio fare direttamente in immagine:

- bordo strappato/vernice/fumo inferiore;
- fumo attorno a Valerio;
- firma decorativa se deve stare sotto il braccio con inclinazione precisa;
- piccoli dettagli scenografici non modificabili spesso;
- effetti fotografici, luci e ombre.

Motivo: questi elementi sono visuali, non contenuto. Se devono essere identici al mockup, il CSS rischia di spostarli o alterarli.

## Cosa Conviene Lasciare In Codice

Meglio lasciare in HTML/CSS:

- menu;
- bottoni;
- social;
- titolo principale `UNA VOCE / OLTRE / IL RING`;
- testo introduttivo;
- sezioni eventi, gallery, bio e contatti.

Motivo: restano leggibili, responsive, modificabili dal pannello e piu' corretti per accessibilita' e SEO.

## Regole Per Le Prossime Modifiche

- Non toccare la hero approvata senza richiesta esplicita.
- Fare una modifica visuale alla volta.
- Usare nomi file nuovi per prove importanti, cosi' la cache non confonde il risultato.
- Se un effetto deve combaciare al pixel con una foto, prima valutare se incorporarlo nell'immagine.
- Prima di committare, includere solo file finali e lasciare fuori prove/scarti.

## Prossime Migliorie Candidate

- Valutare peso visivo dell'header dopo aver completato le sezioni sotto.
- Uniformare bottoni nelle sezioni successive allo stile approvato dell'header.
- Rivedere font/titoli di eventi, gallery e bio.
- Pulire eventuali asset di prova non usati quando il progetto sara' stabile.
