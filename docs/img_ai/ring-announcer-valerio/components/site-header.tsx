'use client'

import { useState } from 'react'
import { ArrowRight, Menu, X } from 'lucide-react'
import { siteConfig } from '@/lib/site-config'
import { BrandLogo } from '@/components/brand-logo'
import { SocialLinks } from '@/components/social-links'

export function SiteHeader() {
  const [open, setOpen] = useState(false)
  const { nav, headerCta } = siteConfig

  return (
    <header className="absolute inset-x-0 top-0 z-50">
      <div className="mx-auto flex max-w-[1400px] items-center justify-between gap-6 px-5 py-5 md:px-8">
        <a href="#home" aria-label="RingAnnouncer Valerio - Home">
          <BrandLogo />
        </a>

        <nav className="hidden items-center gap-7 lg:flex" aria-label="Principale">
          {nav.map((item, i) => (
            <a
              key={item.label}
              href={item.href}
              className={`font-display text-sm tracking-widest transition-colors hover:text-gold ${
                i === 0 ? 'text-gold' : 'text-cream/90'
              }`}
            >
              {item.label}
            </a>
          ))}
        </nav>

        <div className="hidden items-center gap-6 lg:flex">
          <SocialLinks />
          <a
            href={headerCta.href}
            className="group inline-flex items-center gap-2 bg-gold px-5 py-3 font-display text-xs tracking-widest text-ink transition-colors hover:bg-gold-soft"
          >
            {headerCta.label}
            <ArrowRight className="h-4 w-4 transition-transform group-hover:translate-x-1" />
          </a>
        </div>

        <button
          type="button"
          onClick={() => setOpen((v) => !v)}
          className="text-cream lg:hidden"
          aria-label={open ? 'Chiudi menu' : 'Apri menu'}
          aria-expanded={open}
        >
          {open ? <X className="h-7 w-7" /> : <Menu className="h-7 w-7" />}
        </button>
      </div>

      {open && (
        <div className="border-t border-gold/20 bg-ink/95 backdrop-blur lg:hidden">
          <nav className="flex flex-col px-5 py-4" aria-label="Mobile">
            {nav.map((item) => (
              <a
                key={item.label}
                href={item.href}
                onClick={() => setOpen(false)}
                className="border-b border-cream/10 py-3 font-display text-sm tracking-widest text-cream/90"
              >
                {item.label}
              </a>
            ))}
            <div className="flex items-center justify-between pt-5">
              <SocialLinks />
              <a
                href={headerCta.href}
                className="inline-flex items-center gap-2 bg-gold px-5 py-3 font-display text-xs tracking-widest text-ink"
              >
                {headerCta.label}
                <ArrowRight className="h-4 w-4" />
              </a>
            </div>
          </nav>
        </div>
      )}
    </header>
  )
}
