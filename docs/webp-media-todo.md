# WebP e Media Upload

Promemoria per la fase dinamica.

## Gia fatto

- Generati WebP per gli asset statici attualmente usati in home.
- La home usa automaticamente la versione `.webp` quando esiste per gli asset locali del tema.
- I PNG/JPG originali restano come sorgenti/fallback.

## Da completare

- Generare WebP per eventuali immagini statiche ancora mancanti quando verranno reinserite o usate.
- Automatizzare la generazione WebP per tutti i nuovi upload da backoffice.
- Applicare la stessa logica agli upload di:
  - eventi
  - gallery/media
  - partner
  - sfondi sezioni
  - immagini future di pagine dinamiche
- Valutare `srcset`/dimensioni responsive per hero, sezioni larghe e immagini card.
- Evitare conversione forzata per immagini remote, per esempio thumbnail YouTube esterne.

## Regola desiderata

Quando viene caricato un PNG/JPG/JPEG locale, il sistema deve salvare anche una versione `.webp` ottimizzata e il frontend deve preferire WebP se disponibile, mantenendo l'originale come fallback.
