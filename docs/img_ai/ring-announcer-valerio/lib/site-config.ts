export type NavItem = { label: string; href: string }

export type EventItem = {
  day: string
  month: string
  title: string
  location: string
  discipline: string
  image: string
  href: string
}

export type Stat = {
  value: string
  label: string
  icon: 'calendar' | 'users' | 'trophy' | 'star'
}

export const siteConfig = {
  brand: {
    line1: 'RING',
    line2: 'ANNOUNCER',
    sub: 'VALERIO',
  },
  nav: [
    { label: 'HOME', href: '#home' },
    { label: 'EVENTI', href: '#eventi' },
    { label: 'GALLERY', href: '#gallery' },
    { label: 'BIOGRAFIA', href: '#biografia' },
    { label: 'MEDIA', href: '#media' },
    { label: 'CONTATTI', href: '#contatti' },
  ] as NavItem[],
  socials: [
    { label: 'Instagram', href: '#', icon: 'instagram' as const },
    { label: 'Facebook', href: '#', icon: 'facebook' as const },
    { label: 'YouTube', href: '#', icon: 'youtube' as const },
  ],
  headerCta: { label: 'PROSSIMI EVENTI', href: '#eventi' },

  hero: {
    eyebrow: ['SPORT', 'EMOZIONI', 'PERSONE'],
    titleTop: 'UNA VOCE',
    titleMid: 'OLTRE',
    titleBottom: 'IL RING',
    description: 'Eventi, match, persone.\nOgni grande spettacolo inizia con una grande voce.',
    primaryCta: { label: 'SCOPRI CHI SONO', href: '#biografia' },
    videoCta: { label: 'GUARDA IL VIDEO', href: '#media' },
    image: '/images/hero.png',
    sideText: ['SAME', 'SPORT', 'DIFFERENT', 'EMOTIONS'],
    signature: 'Valerio',
    values: ['PASSION', 'DISCIPLINE', 'RESPECT'],
  },

  events: {
    eyebrow: 'NEXT',
    titleTop: 'PROSSIMI',
    titleBottom: 'EVENTI',
    description: "Vivi dal vivo l'energia dei grandi match. Scopri dove sarò il prossimo.",
    cta: { label: 'VAI AL CALENDARIO', href: '#eventi' },
    items: [
      {
        day: '18',
        month: 'GEN',
        title: 'MILANO BOXING NIGHT',
        location: 'Allianz Cloud, Milano',
        discipline: 'Boxe Professionistica',
        image: '/images/event-boxing.png',
        href: '#',
      },
      {
        day: '07',
        month: 'FEB',
        title: 'ITALIAN MUAY THAI LEAGUE',
        location: 'Palazzetto dello Sport, Roma',
        discipline: 'Muay Thai',
        image: '/images/event-muaythai.png',
        href: '#',
      },
      {
        day: '22',
        month: 'MAR',
        title: 'FIGHTING SPIRIT',
        location: 'PalaTrento, Trento',
        discipline: 'MMA',
        image: '/images/event-mma.png',
        href: '#',
      },
      {
        day: '12',
        month: 'APR',
        title: 'VENICE COMBAT',
        location: 'PalaSport Taliercio, Venezia',
        discipline: 'Kickboxing',
        image: '/images/event-kickboxing.png',
        href: '#',
      },
    ] as EventItem[],
  },

  gallery: {
    eyebrow: 'GALLERY',
    titleTop: 'MOMENTI',
    titleBottom: 'CHE RESTANO',
    description: 'Immagini, backstage ed emozioni da dentro e fuori dal ring.',
    cta: { label: 'VAI ALLA GALLERY', href: '#gallery' },
    script: ['People', 'Events', 'Emotions'],
    main: '/images/gallery-main.png',
    thumbs: [
      '/images/gallery-1.png',
      '/images/gallery-2.png',
      '/images/gallery-3.png',
      '/images/gallery-4.png',
    ],
  },

  bio: {
    eyebrow: 'BIOGRAFIA',
    title: 'VALERIO',
    description:
      'Ring announcer, speaker e presentatore specializzato in eventi di boxe, kickboxing, muay thai e MMA. Una passione per lo sport da sempre, una voce al servizio delle emozioni.',
    cta: { label: 'SCOPRI DI PIÙ', href: '#biografia' },
    image: '/images/bio.png',
    quote: 'Lo sport è disciplina, rispetto e passione.\nIl mio compito è dare voce a tutto questo.',
    signature: 'Valerio',
    stats: [
      { value: '100+', label: 'EVENTI ANNUNCIATI', icon: 'calendar' },
      { value: '50+', label: 'CITTÀ IN ITALIA ED EUROPA', icon: 'users' },
      { value: '10+', label: 'DISCIPLINE SPORTIVE', icon: 'trophy' },
      { value: 'UNICA', label: 'UNA GRANDE PASSIONE', icon: 'star' },
    ] as Stat[],
  },

  cta: {
    eyebrow: 'IL RING CONTINUA',
    titleTop: 'READY FOR',
    titleBottom: 'THE NEXT ROUND?',
    label: 'CONTATTAMI',
    description: 'PER EVENTI, COLLABORAZIONI E INFORMAZIONI',
    button: { label: 'SCRIVIMI', href: '#contatti' },
    image: '/images/cta-ropes.png',
  },

  footer: {
    tagline: 'Passione. Ring. Persone.',
    copyright: '© 2024 RingAnnouncer. Tutti i diritti riservati.',
  },
}

export type SiteConfig = typeof siteConfig
