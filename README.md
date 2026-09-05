# RingAnnouncer

Nuovo sito ufficiale RingAnnouncer, in migrazione da Drupal 7.34 a Laravel + Filament.

## Stack previsto

- Laravel
- Filament per il backoffice
- MySQL/MariaDB
- Blade + Tailwind per il frontend
- GSAP per animazioni selettive

## Principi di migrazione

- Il Drupal esistente resta congelato e viene usato solo come sorgente legacy.
- I contenuti vengono rimodellati in entità Laravel pulite, senza replicare la struttura tecnica Drupal.
- Gli URL legacy vengono censiti e preservati quando utile, oppure reindirizzati con 301.
- Media e testi vengono importati mantenendo riferimenti e metadati disponibili.
- Nessuna credenziale, dump SQL o sorgente legacy deve essere commesso nella repository.

Vedi `docs/legacy-audit.md` per la fotografia iniziale del sistema esistente.
