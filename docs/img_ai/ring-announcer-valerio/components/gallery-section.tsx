'use client'

import { useState } from 'react'
import { ArrowRight, ArrowLeft } from 'lucide-react'
import { siteConfig } from '@/lib/site-config'

export function GallerySection() {
  const g = siteConfig.gallery
  const [active, setActive] = useState(0)

  const go = (dir: number) => {
    setActive((prev) => (prev + dir + g.thumbs.length) % g.thumbs.length)
  }

  return (
    <section id="gallery" className="relative overflow-hidden bg-ink py-16 md:py-20">
      <div className="mx-auto grid max-w-[1400px] items-center gap-10 px-5 md:px-8 lg:grid-cols-[300px_1fr]">
        <div>
          <p className="mb-3 font-display text-sm tracking-mega text-gold">{g.eyebrow}</p>
          <h2 className="font-display text-5xl font-bold uppercase leading-[0.9] text-cream">
            {g.titleTop}
            <br />
            {g.titleBottom}
          </h2>
          <p className="mt-5 max-w-xs text-base leading-relaxed text-cream/70">
            {g.description}
          </p>
          <a
            href={g.cta.href}
            className="group mt-6 inline-flex items-center gap-2 bg-gold px-6 py-3 font-display text-sm tracking-widest text-ink transition-colors hover:bg-gold-soft"
          >
            {g.cta.label}
            <ArrowRight className="h-4 w-4 transition-transform group-hover:translate-x-1" />
          </a>
          <div className="mt-6 flex flex-col gap-1 font-script text-3xl leading-tight text-gold/80">
            {g.script.map((word) => (
              <span key={word}>{word}</span>
            ))}
          </div>
        </div>

        <div>
          <div className="grid gap-4 md:grid-cols-[1.4fr_1fr]">
            <div className="relative aspect-[4/3] overflow-hidden md:aspect-auto">
              <img
                src={g.main || '/placeholder.svg'}
                alt="Momento principale della gallery"
                className="h-full w-full object-cover"
              />
            </div>
            <div className="grid grid-cols-2 gap-4">
              {g.thumbs.map((src, i) => (
                <button
                  key={src}
                  type="button"
                  onClick={() => setActive(i)}
                  className={`relative aspect-[4/3] overflow-hidden transition-opacity ${
                    active === i ? 'ring-2 ring-gold' : 'opacity-80 hover:opacity-100'
                  }`}
                  aria-label={`Immagine ${i + 1}`}
                >
                  <img
                    src={src || '/placeholder.svg'}
                    alt={`Momento ${i + 1}`}
                    className="h-full w-full object-cover"
                  />
                </button>
              ))}
            </div>
          </div>

          <div className="mt-6 flex items-center justify-end gap-4">
            <button
              type="button"
              onClick={() => go(-1)}
              className="flex h-9 w-9 items-center justify-center rounded-full border border-gold/50 text-gold transition-colors hover:bg-gold hover:text-ink"
              aria-label="Precedente"
            >
              <ArrowLeft className="h-4 w-4" />
            </button>
            <div className="flex items-center gap-3 font-display text-sm tracking-widest">
              {g.thumbs.map((_, i) => (
                <button
                  key={i}
                  type="button"
                  onClick={() => setActive(i)}
                  className={active === i ? 'text-gold' : 'text-cream/50'}
                >
                  {String(i + 1).padStart(2, '0')}
                </button>
              ))}
            </div>
            <button
              type="button"
              onClick={() => go(1)}
              className="flex h-9 w-9 items-center justify-center rounded-full border border-gold/50 text-gold transition-colors hover:bg-gold hover:text-ink"
              aria-label="Successivo"
            >
              <ArrowRight className="h-4 w-4" />
            </button>
          </div>
        </div>
      </div>
    </section>
  )
}
