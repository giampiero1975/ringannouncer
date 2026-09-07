import { Analytics } from '@vercel/analytics/next'
import type { Metadata, Viewport } from 'next'
import { Oswald, Lora, Great_Vibes } from 'next/font/google'
import './globals.css'

const oswald = Oswald({
  subsets: ['latin'],
  weight: ['400', '500', '600', '700'],
  variable: '--font-oswald',
})

const lora = Lora({
  subsets: ['latin'],
  weight: ['400', '500', '600'],
  variable: '--font-lora',
})

const greatVibes = Great_Vibes({
  subsets: ['latin'],
  weight: ['400'],
  variable: '--font-great-vibes',
})

export const metadata: Metadata = {
  title: 'RingAnnouncer Valerio — Una voce oltre il ring',
  description:
    'Valerio, ring announcer, speaker e presentatore specializzato in eventi di boxe, kickboxing, muay thai e MMA. Eventi, match, persone.',
  generator: 'v0.app',
}

export const viewport: Viewport = {
  themeColor: '#0c0b0a',
}

export default function RootLayout({
  children,
}: Readonly<{
  children: React.ReactNode
}>) {
  return (
    <html
      lang="it"
      className={`bg-ink ${oswald.variable} ${lora.variable} ${greatVibes.variable}`}
    >
      <body className="antialiased">
        {children}
        {process.env.NODE_ENV === 'production' && <Analytics />}
      </body>
    </html>
  )
}
