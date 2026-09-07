import { ArrowRight, Calendar, Users, Trophy, Star, Quote } from 'lucide-react'
import { siteConfig } from '@/lib/site-config'

const statIcons = {
  calendar: Calendar,
  users: Users,
  trophy: Trophy,
  star: Star,
}

export function BioSection() {
  const b = siteConfig.bio
  return (
    <section
      id="biografia"
      className="relative overflow-hidden bg-cream py-16 text-cream-ink md:py-20"
    >
      <div className="mx-auto grid max-w-[1400px] items-center gap-10 px-5 md:px-8 lg:grid-cols-3">
        <div>
          <p className="mb-3 font-display text-sm tracking-mega text-gold">{b.eyebrow}</p>
          <h2 className="font-display text-6xl font-bold uppercase leading-none text-cream-ink">
            {b.title}
          </h2>
          <p className="mt-5 text-base leading-relaxed text-cream-ink/75">{b.description}</p>
          <a
            href={b.cta.href}
            className="group mt-6 inline-flex items-center gap-2 border border-cream-ink/30 px-6 py-3 font-display text-sm tracking-widest text-cream-ink transition-colors hover:border-gold hover:text-gold"
          >
            {b.cta.label}
            <ArrowRight className="h-4 w-4 transition-transform group-hover:translate-x-1" />
          </a>
        </div>

        <div className="relative aspect-[4/5] overflow-hidden">
          <img
            src={b.image || '/placeholder.svg'}
            alt="Ritratto di Valerio con il microfono"
            className="h-full w-full object-cover"
          />
        </div>

        <div className="flex flex-col gap-8">
          <figure>
            <Quote className="h-8 w-8 text-gold" aria-hidden="true" />
            <blockquote className="mt-3 whitespace-pre-line font-serif text-xl leading-relaxed text-cream-ink">
              {b.quote}
            </blockquote>
            <figcaption className="mt-2 font-script text-4xl text-cream-ink">
              {b.signature}
            </figcaption>
          </figure>

          <ul className="flex flex-col gap-4 border-t border-cream-ink/15 pt-6">
            {b.stats.map((stat) => {
              const Icon = statIcons[stat.icon]
              return (
                <li key={stat.label} className="flex items-center gap-4">
                  <Icon className="h-7 w-7 shrink-0 text-gold" aria-hidden="true" />
                  <div className="leading-tight">
                    <span className="block font-display text-xl font-bold text-cream-ink">
                      {stat.value}
                    </span>
                    <span className="text-xs tracking-widest text-cream-ink/60">
                      {stat.label}
                    </span>
                  </div>
                </li>
              )
            })}
          </ul>
        </div>
      </div>
    </section>
  )
}
