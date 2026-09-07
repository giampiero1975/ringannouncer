import { Crown } from 'lucide-react'
import { siteConfig } from '@/lib/site-config'
import { cn } from '@/lib/utils'

export function BrandLogo({ className }: { className?: string }) {
  const { line1, line2, sub } = siteConfig.brand
  return (
    <div className={cn('flex flex-col items-center leading-none', className)}>
      <Crown className="mb-1 h-4 w-4 text-gold" aria-hidden="true" />
      <div className="font-display text-lg font-semibold tracking-wide">
        <span className="text-cream">{line1}</span>
        <span className="font-normal text-cream/80">{line2}</span>
      </div>
      <div className="mt-1 flex w-full items-center gap-2">
        <span className="h-px flex-1 bg-gold/60" />
        <span className="font-display text-[0.6rem] tracking-mega text-gold">{sub}</span>
        <span className="h-px flex-1 bg-gold/60" />
      </div>
    </div>
  )
}
