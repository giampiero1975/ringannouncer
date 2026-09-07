import { ArrowRight, MapPin, Dumbbell } from 'lucide-react'
import { siteConfig } from '@/lib/site-config'

export function EventsSection() {
  const e = siteConfig.events
  return (
    <section id="eventi" className="bg-cream py-16 text-cream-ink md:py-20">
      <div className="mx-auto grid max-w-[1400px] gap-10 px-5 md:px-8 lg:grid-cols-[300px_1fr]">
        <div>
          <p className="mb-3 font-display text-sm tracking-mega text-gold">{e.eyebrow}</p>
          <h2 className="font-display text-5xl font-bold uppercase leading-[0.9] text-cream-ink">
            {e.titleTop}
            <br />
            {e.titleBottom}
          </h2>
          <p className="mt-5 max-w-xs text-base leading-relaxed text-cream-ink/70">
            {e.description}
          </p>
          <a
            href={e.cta.href}
            className="group mt-6 inline-flex items-center gap-2 font-display text-sm tracking-widest text-gold"
          >
            {e.cta.label}
            <ArrowRight className="h-4 w-4 transition-transform group-hover:translate-x-1" />
          </a>
        </div>

        <div className="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
          {e.items.map((item) => (
            <a
              key={item.title}
              href={item.href}
              className="group relative flex aspect-[3/4] flex-col justify-end overflow-hidden bg-ink"
            >
              <img
                src={item.image || '/placeholder.svg'}
                alt={item.title}
                className="absolute inset-0 h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
              />
              <div className="absolute inset-0 bg-gradient-to-t from-ink via-ink/50 to-ink/10" />

              <div className="absolute left-4 top-4 bg-gold px-3 py-2 text-center font-display leading-none text-ink">
                <span className="block text-2xl font-bold">{item.day}</span>
                <span className="block text-xs tracking-widest">{item.month}</span>
              </div>

              <div className="relative z-10 p-4">
                <h3 className="font-display text-lg font-semibold uppercase text-cream">
                  {item.title}
                </h3>
                <p className="mt-3 flex items-center gap-2 text-sm text-cream/80">
                  <MapPin className="h-4 w-4 text-gold" />
                  {item.location}
                </p>
                <p className="mt-2 flex items-center justify-between gap-2 text-sm text-cream/80">
                  <span className="flex items-center gap-2">
                    <Dumbbell className="h-4 w-4 text-gold" />
                    {item.discipline}
                  </span>
                  <span className="flex h-8 w-8 items-center justify-center rounded-full border border-gold/70 text-gold transition-colors group-hover:bg-gold group-hover:text-ink">
                    <ArrowRight className="h-4 w-4" />
                  </span>
                </p>
              </div>
            </a>
          ))}
        </div>
      </div>
    </section>
  )
}
