<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="SYMBIOZ — Plomberie, électricité, peinture, menuiserie et rénovation à Toulouse.">
    <title>@yield('title', 'SYMBIOZ — Votre partenaire bâtiment')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex flex-col bg-gray-50 font-sans text-gray-900 antialiased">

    {{-- ========== HEADER ========== --}}
    <header class="bg-white border-b border-gray-200" x-data="{ open: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">

                {{-- Logo --}}
                <a href="{{ route('front.home') }}" class="text-2xl font-extrabold tracking-tight">
                    symbioz<span class="text-accent">.</span>
                </a>

                {{-- Nav desktop --}}
                <nav class="hidden md:flex items-center gap-8 text-sm font-medium">
                    <a href="{{ route('front.home') }}" class="hover:text-brand transition">Accueil</a>
                    <a href="{{ route('front.services') }}" class="hover:text-brand transition">Nos services</a>
                    <a href="{{ route('front.quote.create') }}" class="hover:text-brand transition">Demander un devis</a>
                    <a href="{{ route('front.quick.create') }}" class="text-red-600 font-semibold hover:text-red-700 transition">Urgence</a>
                </nav>

                {{-- CTA desktop --}}
                <a href="{{ route('login') }}" class="hidden md:inline-flex items-center px-4 py-2 bg-brand text-white text-sm font-semibold rounded-lg hover:bg-brand-dark transition">
                    Espace Pro
                </a>

                {{-- Burger mobile --}}
                <button @click="open = !open" class="md:hidden p-2 text-gray-600 hover:text-brand" aria-label="Menu">
                    <svg x-show="!open" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg x-show="open" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            {{-- Nav mobile --}}
            <div x-show="open" x-cloak x-transition class="md:hidden pb-4 space-y-2">
                <a href="{{ route('front.home') }}" class="block px-3 py-2 rounded-lg text-sm font-medium hover:bg-gray-100">Accueil</a>
                <a href="{{ route('front.services') }}" class="block px-3 py-2 rounded-lg text-sm font-medium hover:bg-gray-100">Nos services</a>
                <a href="{{ route('front.quote.create') }}" class="block px-3 py-2 rounded-lg text-sm font-medium hover:bg-gray-100">Demander un devis</a>
                <a href="{{ route('front.quick.create') }}" class="block px-3 py-2 rounded-lg text-sm font-medium text-red-600 hover:bg-red-50">Urgence</a>
                <a href="{{ route('login') }}" class="block px-3 py-2 rounded-lg text-sm font-semibold text-brand hover:bg-brand-light">Espace Pro</a>
            </div>
        </div>
    </header>

    {{-- ========== CONTENU ========== --}}
    <main class="flex-1">
        @yield('content')
    </main>

    {{-- ========== FOOTER ========== --}}
    <footer class="bg-gray-900 text-gray-400">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">

                {{-- Col 1 : Brand --}}
                <div>
                    <a href="{{ route('front.home') }}" class="text-xl font-extrabold text-white">
                        symbioz<span class="text-accent">.</span>
                    </a>
                    <p class="mt-3 text-sm leading-relaxed">
                        Plomberie, électricité, peinture, plâtrerie, menuiserie : nos équipes interviennent pour particuliers et professionnels.
                    </p>
                </div>

                {{-- Col 2 : Services --}}
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-4">Nos services</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('front.services') }}" class="hover:text-white transition">Plomberie</a></li>
                        <li><a href="{{ route('front.services') }}" class="hover:text-white transition">Électricité</a></li>
                        <li><a href="{{ route('front.services') }}" class="hover:text-white transition">Peinture & Plâtrerie</a></li>
                        <li><a href="{{ route('front.services') }}" class="hover:text-white transition">Menuiserie</a></li>
                    </ul>
                </div>

                {{-- Col 3 : Entreprise --}}
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-wider text-gray-500 mb-4">Entreprise</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('front.services') }}" class="hover:text-white transition">Nos réalisations</a></li>
                        <li><a href="{{ route('front.quote.create') }}" class="hover:text-white transition">Demander un devis</a></li>
                    </ul>
                </div>

                {{-- Col 4 : Légal --}}
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-wider text-gray-500 mb-4">Légal</h3>
                    <ul class="space-y-2 text-sm">
                        <li><span>Mentions légales</span></li>
                        <li><span>Données personnelles</span></li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-800 mt-10 pt-6 flex flex-col sm:flex-row items-center justify-between text-xs">
                <span>&copy; {{ date('Y') }} SYMBIOZ · PROJET PÉDAGOGIQUE · TITRE DWWM</span>
                <span class="mt-2 sm:mt-0">Conçu à Toulouse</span>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
