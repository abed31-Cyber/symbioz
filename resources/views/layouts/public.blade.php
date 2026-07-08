<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Accueil') — SYMBIOZ</title>
    <meta name="description"
          content="@yield('meta_description', 'SYMBIOZ — Artisans du BTP second œuvre. Demandez votre devis en ligne.')">

    {{-- Assets compilés par Vite : Tailwind + Alpine sont fournis par Breeze --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('head')
</head>
<body class="min-h-screen flex flex-col bg-slate-50 text-slate-800 antialiased">

    {{-- Lien d'évitement : accessibilité clavier (WCAG) --}}
    <a href="#main-content"
       class="sr-only focus:not-sr-only focus:absolute focus:top-2 focus:left-2 focus:z-50 focus:rounded-md focus:bg-indigo-600 focus:px-4 focus:py-2 focus:text-white">
        Aller au contenu principal
    </a>

    {{-- ===================== HEADER ===================== --}}
    <header x-data="{ open: false }"
            class="sticky top-0 z-40 border-b border-slate-200 bg-white/90 backdrop-blur">
        <nav class="mx-auto flex max-w-6xl items-center justify-between px-4 py-3"
             aria-label="Navigation principale">

            {{-- Marque --}}
            <a href="{{ route('front.home') }}"
               class="flex items-center gap-2 text-xl font-bold tracking-tight text-slate-900">
                <span class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-indigo-600 text-white">S</span>
                SYMBIOZ
            </a>

            {{-- Navigation desktop --}}
            <div class="hidden items-center gap-6 md:flex">
                <a href="{{ route('front.home') }}"
                   @if(request()->routeIs('front.home')) aria-current="page" @endif
                   class="text-sm font-medium hover:text-indigo-600 {{ request()->routeIs('front.home') ? 'text-indigo-600' : 'text-slate-600' }}">
                    Accueil
                </a>
                <a href="{{ route('front.services') }}"
                   @if(request()->routeIs('front.services')) aria-current="page" @endif
                   class="text-sm font-medium hover:text-indigo-600 {{ request()->routeIs('front.services') ? 'text-indigo-600' : 'text-slate-600' }}">
                    Services
                </a>
                <a href="{{ route('front.quote-request.create') }}"
                   class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Demander un devis
                </a>
            </div>

            {{-- Bouton menu mobile --}}
            <button type="button"
                    @click="open = !open"
                    :aria-expanded="open"
                    aria-controls="mobile-menu"
                    class="inline-flex items-center justify-center rounded-md p-2 text-slate-600 hover:bg-slate-100 md:hidden">
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
        </nav>

        {{-- Panneau mobile --}}
        <div x-show="open" x-cloak id="mobile-menu"
             @keydown.escape.window="open = false"
             class="border-t border-slate-200 md:hidden">
            <div class="space-y-1 px-4 py-3">
                <a href="{{ route('front.home') }}"
                   class="block rounded-md px-3 py-2 text-base font-medium text-slate-700 hover:bg-slate-100">Accueil</a>
                <a href="{{ route('front.services') }}"
                   class="block rounded-md px-3 py-2 text-base font-medium text-slate-700 hover:bg-slate-100">Services</a>
                <a href="{{ route('front.quote-request.create') }}"
                   class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-base font-semibold text-white hover:bg-indigo-700">Demander un devis</a>
            </div>
        </div>
    </header>

    {{-- ===================== CONTENU ===================== --}}
    <main id="main-content" class="flex-1">
        @yield('content')
    </main>

    {{-- ===================== FOOTER ===================== --}}
    <footer class="border-t border-slate-200 bg-white">
        <div class="mx-auto flex max-w-6xl flex-col items-center justify-between gap-4 px-4 py-6 sm:flex-row">
            <p class="text-sm text-slate-500">© {{ date('Y') }} SYMBIOZ — Artisans du BTP. Tous droits réservés.</p>
            <nav class="flex gap-4 text-sm text-slate-500" aria-label="Liens de pied de page">
                <a href="{{ route('front.home') }}" class="hover:text-indigo-600">Accueil</a>
                <a href="{{ route('front.services') }}" class="hover:text-indigo-600">Services</a>
                <a href="{{ route('front.quote-request.create') }}" class="hover:text-indigo-600">Devis</a>
            </nav>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
