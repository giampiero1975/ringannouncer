import { ArrowRight } from 'lucide-react'
import { siteConfig } from '@/lib/site-config'

export function CtaSection() {
  const c = siteConfig.cta
  return (
    <section id="contatti" className="relative overflow-hidden bg-ink">
      <img
        src={c.image || '/placeholder.svg'}
        alt=""
        aria-hidden="true"
        className="absolute inset-0 h-full w-full object-cover opacity-40"
      />
      <div className="absolute inset-0 bg-gradient-to-r from-ink via-ink/85 to-ink/40" />

      <div className="relative mx-auto flex max-w-[1400px] flex-col items-start gap-8 px-5 py-16 md:flex-row md:items-center md:justify-between md:px-8 md:py-20">
        <div>
          <p className="mb-2 font-display text-sm tracking-mega text-gold">{c.eyebrow}</p>
          <h2 className="font-display font-bold uppercase leading-[0.9] text-cream">
            <span className="block text-4xl md:text-5xl">{c.titleTop}</span>
            <span className="block text-4xl text-gold md:text-5xl">{c.titleBottom}</span>
          </h2>
        </div>

        <div className="flex flex-col items-start gap-5 md:flex-row md:items-center">
          <div className="md:border-l md:border-cream/20 md:pl-8">
            <p className="font-display text-lg tracking-widest text-cream">{c.label}</p>
            <p className="mt-1 text-sm tracking-wide text-cream/70">{c.description}</p>
          </div>
          <a
            href={c.button.href}
            className="group inline-flex items-center gap-2 bg-gold px-7 py-4 font-display text-sm tracking-widest text-ink transition-colors hover:bg-gold-soft"
          >
            {c.button.label}
            <ArrowRight className="h-4 w-4 transition-transform group-hover:translate-x-1" />
          </a>
        </div>
      </div>
    </section>
  )
}
