import { SiteHeader } from '@/components/site-header'
import { HeroSection } from '@/components/hero-section'
import { EventsSection } from '@/components/events-section'
import { GallerySection } from '@/components/gallery-section'
import { BioSection } from '@/components/bio-section'
import { CtaSection } from '@/components/cta-section'
import { SiteFooter } from '@/components/site-footer'

export default function Page() {
  return (
    <div className="relative bg-ink">
      <SiteHeader />
      <main>
        <HeroSection />
        <EventsSection />
        <GallerySection />
        <BioSection />
        <CtaSection />
      </main>
      <SiteFooter />
    </div>
  )
}
