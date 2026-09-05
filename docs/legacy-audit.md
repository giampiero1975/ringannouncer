# Legacy Audit — RingAnnouncer Drupal

Data audit: 2026-09-05

## Sistema sorgente

- CMS: Drupal 7.34
- PHP hosting corrente: 7.2.34
- DB server: Percona Server 5.7.44-48 (compatibile MySQL 5.7)
- Charset dump: UTF-8/utf8mb4 in esportazione; il server Aruba espone anche impostazioni legacy latin1/cp1252 da tenere presenti durante il porting
- Tema predefinito DB: Bartik
- Tema admin: Seven

Il sistema va considerato legacy e congelato: non è necessario aggiornarlo per effettuare la migrazione.

## Content type reali

Nel database sono definiti:

- `article`
- `curiosit_`
- `event`
- `gallery`
- `page`
- `portfolio`

I contenuti realmente presenti sono 577 nodi:

- `portfolio`: 493
- `curiosit_`: 79 (78 pubblicati, 1 non pubblicato)
- `page`: 3
- `gallery`: 2
- `event`: 0
- `article`: 0

### Osservazione importante sul calendario

Il content type Drupal `event` esiste ma non contiene nodi. Il calendario attuale usa invece il content type `portfolio` tramite `field_event_date`.

Questo conferma che nel nuovo Laravel conviene avere una singola entità `Event`: gli elementi futuri vengono mostrati nel calendario, quelli passati nello storico/portfolio, senza duplicare i dati.

## Campi Drupal utilizzati

### Portfolio / eventi storici

- `node.title`
- `body`
- `field_event_date`
- `field_categoria` su 95 record

`field_event_date` è presente su tutti i 493 portfolio.

`field_categoria` usa una lista di categorie di peso pugilistico:

1. Paglia
2. Mosca leggeri
3. Mosca
4. Supermosca (Gallo jr.)
5. Gallo
6. Supergallo (Piuma jr.)
7. Piuma
8. Superpiuma (Leggeri jr.)
9. Leggeri
10. Superleggeri (Welter jr., Welter leggeri)
11. Welter
12. Superwelter (Medi jr., Medi leggeri)
13. Medi
14. Supermedi
15. Mediomassimi
16. Massimi leggeri (Cruiser)
17. Massimi

Intervallo date rilevato nei portfolio: 2005-06-09 → 2026-01-04.

### Curiosità

- `node.title`
- `body`
- `field_date`

Sono presenti 79 record.

### Gallery

- `body`
- `field_picture`

`field_picture` contiene 47 immagini gestite dal file system Drupal e dal database.

### Video

La pagina Drupal `node/37` salva direttamente iframe YouTube nel body. Sono stati rilevati 13 embed YouTube. Nel nuovo sistema vanno normalizzati in una tabella `videos` contenente almeno `youtube_id`, titolo, descrizione, ordinamento ed eventuale relazione con un evento.

## Media

Tabella `file_managed`:

- 47 file registrati
- circa 6 MB complessivi
- 40 JPG
- 6 PNG
- 1 JPEG

Cartella `sites/default/files`:

- 139 file fisici
- circa 9.7 MB
- contiene anche file non più referenziati dal DB

La migrazione dovrà distinguere i media realmente referenziati da quelli orfani prima di importarli nello storage Laravel.

Il pacchetto sorgente contiene inoltre materiale legacy precedente a Drupal, soprattutto nelle directory `bk/` e `cms/`. Queste directory non devono essere copiate automaticamente nel nuovo sito: vanno considerate archivi storici e analizzate solo se contengono asset utili mancanti dal Drupal attuale.

## Menu pubblico legacy

Il menu principale memorizzato nel DB contiene:

1. Home
2. Chi sono
3. Contact
4. Portfolio
5. Curiosità
6. Gallery
7. Video

È inoltre presente un blocco `Partner` nel layout.

## URL e SEO

La tabella `url_alias` contiene solo un alias esplicito:

- `node/2` → `chi-sono`

Molti contenuti sono quindi raggiunti tramite URL Drupal (`node/{nid}`) o tramite Views (`portfolio`, `curiosit-`, calendario, ecc.).

Nel nuovo Laravel dovremo generare una mappa legacy per tutti i nodi importanti e mantenere gli URL quando opportuno oppure rispondere con redirect 301 verso i nuovi slug.

## Moduli contrib rilevati e abilitati

Tra i principali:

- Views / Views UI
- Calendar
- Date
- CKEditor
- Colorbox
- Context
- CTools
- EU Cookie Compliance
- Insert
- Libraries
- Token

Non risultano necessari nel nuovo sistema: le relative responsabilità verranno assorbite da Laravel, Filament e dal frontend custom.

## Modello Laravel proposto

### `events`

Sostituisce `portfolio` e la logica calendario.

Campi iniziali proposti:

- `id`
- `legacy_drupal_id`
- `title`
- `slug`
- `description`
- `event_date`
- `event_end_date` nullable
- `status` (`scheduled`, `completed`, `cancelled`, `postponed`)
- `venue` nullable
- `city` nullable
- `country` nullable
- `weight_category` nullable
- `cover_image` nullable
- `is_featured`
- `is_published`
- SEO fields
- timestamps

Il calendario pubblico mostra gli eventi futuri/scheduled. Lo storico mostra quelli conclusi.

### `articles`

Sostituisce `curiosit_`.

### `galleries` + `media`

Le gallery diventano entità strutturate; le immagini vengono normalizzate e possono essere collegate anche agli eventi.

### `videos`

Normalizza gli iframe YouTube esistenti.

### `pages`

Contiene le pagine statiche (Home editoriale, Chi sono, ecc.).

### `partners`

Sostituisce il blocco HTML legacy dei partner.

### `social_links`

Gestisce YouTube, Instagram, Facebook, TikTok e altri profili senza hardcoding nel template.

### `redirects`

Mappa i vecchi percorsi Drupal verso i nuovi URL Laravel.

## Strategia di import

1. Creare schema Laravel pulito.
2. Configurare una connessione DB `legacy_drupal` separata o importare il dump in un DB locale temporaneo.
3. Importare `portfolio` → `events` mantenendo `legacy_drupal_id`.
4. Importare `curiosit_` → `articles`.
5. Importare pagine statiche.
6. Importare `file_managed` e `field_picture` nello storage Laravel.
7. Estrarre gli ID YouTube dalla pagina Video.
8. Generare la tabella di redirect legacy.
9. Validare conteggi e checksum/log di migrazione.
10. Eseguire una seconda importazione finale poco prima del go-live se il vecchio Drupal riceve ancora aggiornamenti.

## Conteggi di controllo per il futuro importer

L'importer dovrà produrre almeno questi gate:

- portfolio sorgente: 493
- curiosità sorgente: 79
- pagine sorgente: 3
- gallery sorgente: 2
- immagini DB gallery: 47
- video YouTube rilevati: 13
- nodi totali: 577

Qualsiasi differenza dovrà essere esplicitamente spiegata nel report di importazione.
