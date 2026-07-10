<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Accueil') SYMBIOZ</title>
    <meta name="description"
          content="@yield('meta_description', 'SYMBIOZ — Artisans du BTP second œuvre à Toulouse. Devis gratuit en ligne.')">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
<body class="min-h-screen flex flex-col bg-white text-slate-800 antialiased">

    {{-- Lien d'évitement (accessibilité WCAG) --}}
    <a href="#main-content"
       class="sr-only focus:not-sr-only focus:absolute focus:top-2 focus:left-2 focus:z-50 focus:rounded-md focus:bg-indigo-600 focus:px-4 focus:py-2 focus:text-white">
        Aller au contenu principal
    </a>

    {{-- ===================== HEADER ===================== --}}
    <header x-data="{ open: false }"
            class="sticky top-0 z-40 border-b border-slate-200 bg-white/95 backdrop-blur">
        <nav class="mx-auto flex max-w-7xl items-center justify-between px-4 py-3 lg:px-8"
             aria-label="Navigation principale">

            {{-- Logo (Zone Gauche) - Point Orange --}}
            <div class="flex flex-1">
                <a href="{{ route('front.home') }}" class="text-xl font-extrabold tracking-tight text-slate-900">
                    symbioz<span class="text-orange-500">.</span>
                </a>
            </div>

            {{-- Navigation desktop (Zone Centre) --}}
            <div class="hidden md:flex md:gap-x-8">
                <a href="{{ route('front.services') }}"
                   class="text-sm font-bold text-indigo-600 hover:text-slate-900">Nos services</a>
                <a href="{{ route('front.home') }}#realisations"
                   class="text-sm font-medium text-slate-600 hover:text-slate-900">Réalisations</a>
                <a href="{{ route('front.home') }}#a-propos"
                   class="text-sm font-medium text-slate-600 hover:text-slate-900">À propos</a>
                <a href="{{ route('front.home') }}#faq"
                   class="text-sm font-medium text-slate-600 hover:text-slate-900">FAQ</a>
            </div>

            {{-- Bouton d'action (Zone Droite) --}}
            <div class="hidden flex-1 items-center justify-end md:flex">
                <a href="{{ route('front.quote-request.create') }}"
                   class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Demander un devis
                </a>
            </div>

            {{-- Bouton menu mobile --}}
            <div class="flex items-center md:hidden">
                <button type="button"
                        @click="open = !open"
                        :aria-expanded="open"
                        aria-controls="mobile-menu"
                        class="inline-flex items-center justify-center rounded-md p-2 text-slate-600 hover:bg-slate-100">
                    <span class="sr-only">Ouvrir le menu</span>
                    <svg x-show="!open" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                         stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5M3.75 17.25h16.5" />
                    </svg>
                    <svg x-show="open" x-cloak class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                         stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </nav>

        {{-- Panneau mobile --}}
        <div x-show="open" x-cloak id="mobile-menu"
             @keydown.escape.window="open = false"
             class="border-t border-slate-200 md:hidden">
            <div class="space-y-1 px-4 py-3">
                <a href="{{ route('front.services') }}"
                   class="block rounded-md px-3 py-2 text-base font-medium text-slate-700 hover:bg-slate-100">Nos services</a>
                <a href="{{ route('front.home') }}#realisations"
                   class="block rounded-md px-3 py-2 text-base font-medium text-slate-700 hover:bg-slate-100">Réalisations</a>
                <a href="{{ route('front.home') }}#a-propos"
                   class="block rounded-md px-3 py-2 text-base font-medium text-slate-700 hover:bg-slate-100">À propos</a>
                <a href="{{ route('front.home') }}#faq"
                   class="block rounded-md px-3 py-2 text-base font-medium text-slate-700 hover:bg-slate-100">FAQ</a>
                <a href="{{ route('front.quote-request.create') }}"
                   class="mt-2 block rounded-md bg-indigo-600 px-3 py-2 text-center text-base font-semibold text-white hover:bg-indigo-700">
                    Demander un devis
                </a>
            </div>
        </div>
    </header>

    {{-- ===================== CONTENU ===================== --}}
    <main id="main-content" class="flex-1">
        @yield('content')
    </main>

    {{-- ===================== FOOTER ===================== --}}
    <footer class="border-t border-slate-200 bg-slate-900 text-slate-300">
        <div class="mx-auto max-w-7xl px-4 py-12 lg:px-8">
            <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-4">
                {{-- Colonne marque - Point Orange --}}
                <div>
                    <p class="text-lg font-extrabold text-white">symbioz<span class="text-orange-500">.</span></p>
                    <p class="mt-3 text-sm leading-relaxed">
                        Entreprise de second œuvre basée à Toulouse.
                        Plomberie, électricité, peinture, plâtrerie, menuiserie :
                        nos équipes interviennent pour particuliers et professionnels.
                    </p>
                </div>
                {{-- Colonne services --}}
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-wider text-white 400">Nos services</h3>
                    <ul class="mt-3 space-y-2 text-sm">
                        <li><a href="{{ route('front.services') }}" class="hover:text-white">Plomberie</a></li>
                        <li><a href="{{ route('front.services') }}" class="hover:text-white">Électricité</a></li>
                        <li><a href="{{ route('front.services') }}" class="hover:text-white">Peinture & Plâtrerie</a></li>
                        <li><a href="{{ route('front.services') }}" class="hover:text-white">Menuiserie</a></li>
                    </ul>
                </div>
                {{-- Colonne entreprise --}}
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-wider text-white 400">Entreprise</h3>
                    <ul class="mt-3 space-y-2 text-sm">
                        <li><a href="{{ route('front.home') }}#a-propos" class="hover:text-white">À propos</a></li>
                        <li><a href="{{ route('front.home') }}#realisations" class="hover:text-white">Nos réalisations</a></li>
                        <li><a href="{{ route('front.home') }}#temoignages" class="hover:text-white">Nos engagements</a></li>
                        <li><a href="{{ route('front.home') }}#temoignages" class="hover:text-white">Recrutement</a></li>
                    </ul>
                </div>
                {{-- Colonne légal --}}
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-wider text-white 400">Légal</h3>
                    <ul class="mt-3 space-y-2 text-sm">
                        <li><a href="#" class="hover:text-white">Mentions légales</a></li>
                        <li><a href="#" class="hover:text-white">Données personnelles</a></li>
                        <li><a href="#" class="hover:text-white">CGV</a></li>
                         <li><a href="#" class="hover:text-white">Cookies</a></li>
                    </ul>
                </div>
            </div>
            <div class="mt-10 border-t border-slate-700 pt-6 text-center text-xs text-slate-500">
                © {{ date('Y') }} SYMBIOZ · PROJET PÉDAGOGIQUE · TITRE DWWM LA PLATEFORME
                <span class="mx-2">·</span>
                Conçu à Toulouse - La Cartoucherie
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
