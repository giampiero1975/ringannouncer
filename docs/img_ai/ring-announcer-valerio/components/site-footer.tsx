import { ArrowUp } from 'lucide-react'
import { siteConfig } from '@/lib/site-config'
import { BrandLogo } from '@/components/brand-logo'
import { SocialLinks } from '@/components/social-links'

export function SiteFooter() {
  const { nav, footer } = siteConfig
  return (
    <footer className="border-t border-gold/20 bg-ink py-8">
      <div className="mx-auto flex max-w-[1400px] flex-col gap-6 px-5 md:px-8 lg:flex-row lg:items-center lg:justify-between">
        <div className="flex flex-col items-start gap-2">
          <BrandLogo className="items-start" />
          <p className="text-xs text-cream/40">{footer.copyright}</p>
        </div>

        <nav className="flex flex-wrap gap-6" aria-label="Footer">
          {nav.map((item, i) => (
            <a
              key={item.label}
              href={item.href}
              className={`font-display text-xs tracking-widest transition-colors hover:text-gold ${
                i === 0 ? 'text-gold' : 'text-cream/80'
              }`}
            >
              {item.label}
            </a>
          ))}
        </nav>

        <div className="flex items-center gap-6">
          <SocialLinks />
          <span className="hidden h-6 w-px bg-cream/20 md:block" />
          <p className="font-display text-sm tracking-widest text-cream/60">{footer.tagline}</p>
          <a
            href="#home"
            aria-label="Torna su"
            className="flex h-9 w-9 items-center justify-center border border-gold/50 text-gold transition-colors hover:bg-gold hover:text-ink"
          >
            <ArrowUp className="h-4 w-4" />
          </a>
        </div>
      </div>
    </footer>
  )
}
