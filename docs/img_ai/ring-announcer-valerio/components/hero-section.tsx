import { ArrowRight, Play } from 'lucide-react'
import { siteConfig } from '@/lib/site-config'

export function HeroSection() {
  const h = siteConfig.hero
  return (
    <section
      id="home"
      className="relative min-h-[780px] overflow-hidden bg-ink"
    >
      <img
        src={h.image || '/placeholder.svg'}
        alt="Valerio, ring announcer sul palco con il microfono"
        className="absolute inset-0 h-full w-full object-cover object-[70%_center]"
      />
      <div className="absolute inset-0 bg-gradient-to-r from-ink via-ink/70 to-ink/20" />
      <div className="absolute inset-x-0 bottom-0 h-40 bg-gradient-to-t from-cream to-transparent" />

      <div className="relative mx-auto flex min-h-[780px] max-w-[1400px] flex-col justify-center px-5 pt-28 pb-24 md:px-8">
        <p className="mb-4 font-display text-sm tracking-mega text-gold">
          {h.eyebrow.join('  ·  ')}
        </p>
        <h1 className="font-display font-bold uppercase leading-[0.85]">
          <span className="block text-6xl text-cream md:text-8xl">{h.titleTop}</span>
          <span className="block text-6xl text-gold md:text-8xl">{h.titleMid}</span>
          <span className="block text-6xl text-gold md:text-8xl">{h.titleBottom}</span>
        </h1>
        <p className="mt-6 max-w-sm whitespace-pre-line text-lg leading-relaxed text-cream/85">
          {h.description}
        </p>

        <div className="mt-8 flex flex-wrap items-center gap-6">
          <a
            href={h.primaryCta.href}
            className="group inline-flex items-center gap-2 bg-gold px-7 py-4 font-display text-sm tracking-widest text-ink transition-colors hover:bg-gold-soft"
          >
            {h.primaryCta.label}
            <ArrowRight className="h-4 w-4 transition-transform group-hover:translate-x-1" />
          </a>
          <a href={h.videoCta.href} className="group inline-flex items-center gap-3">
            <span className="flex h-14 w-14 items-center justify-center rounded-full border border-gold/70 text-gold transition-colors group-hover:bg-gold group-hover:text-ink">
              <Play className="h-5 w-5 translate-x-0.5 fill-current" />
            </span>
            <span className="font-display text-sm tracking-widest text-cream">
              {h.videoCta.label}
            </span>
          </a>
        </div>
      </div>

      <div className="pointer-events-none absolute right-8 top-1/2 hidden -translate-y-1/2 flex-col items-end gap-6 lg:flex">
        <div className="flex flex-col items-end gap-1 font-display tracking-mega text-cream/80">
          {h.sideText.map((word) => (
            <span key={word} className="text-lg">
              {word}
            </span>
          ))}
          <span className="mt-2 h-0.5 w-10 bg-gold" />
        </div>
        <p className="font-script text-6xl text-gold">{h.signature}</p>
        <ul className="flex flex-col items-end gap-1 font-display text-sm tracking-widest text-cream/80">
          {h.values.map((v) => (
            <li key={v}>{v}</li>
          ))}
        </ul>
      </div>
    </section>
  )
}
