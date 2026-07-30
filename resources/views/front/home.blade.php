@extends('layouts.public')

@section('title', 'SYMBIOZ — Vos travaux entre de bonnes mains')

@section('content')

    {{-- ============ HERO ============ --}}
    <section class="bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14 lg:py-20">
            <div class="lg:grid lg:grid-cols-2 lg:gap-12 lg:items-center">

                {{-- Colonne gauche --}}
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-brand-light text-brand text-xs font-semibold mb-6">
                        <span class="w-2 h-2 rounded-full bg-brand"></span>
                        Artisans de confiance depuis 2010
                    </div>
                    <h1 class="text-4xl sm:text-5xl font-extrabold tracking-tight leading-[1.1]">
                        Vos travaux<br><span class="text-brand">entre de bonnes mains.</span>
                    </h1>
                    <p class="mt-6 text-lg text-gray-600 leading-relaxed max-w-xl">
                        SYMBIOZ réalise vos travaux de second œuvre : plomberie, électricité,
                        peinture, plâtrerie, menuiserie pour les particuliers et professionnels
                        de toute l'agglomération toulousaine.
                    </p>
                    <div class="mt-8 flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('front.quote.create') }}"
                           class="inline-flex items-center justify-center px-6 py-3.5 bg-brand text-white font-semibold rounded-xl hover:bg-brand-dark transition">
                            Demander un devis gratuit
                        </a>
                        <a href="{{ route('front.quick.create') }}"
                           class="inline-flex items-center justify-center px-6 py-3.5 border border-gray-300 text-gray-900 font-semibold rounded-xl hover:border-brand hover:text-brand transition">
                            Voir nos réalisations
                        </a>
                    </div>
                </div>

                {{-- Colonne droite : carte devis flottante --}}
                <div class="mt-12 lg:mt-0">
                    <div class="bg-white rounded-2xl border border-gray-200 shadow-xl p-6 max-w-md mx-auto">
                        <div class="flex items-center gap-2 text-brand text-sm font-semibold mb-5">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Devis gratuit sous 48h
                        </div>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between p-4 rounded-xl bg-gray-50 border border-gray-100">
                                <div>
                                    <p class="text-xs text-gray-500 uppercase tracking-wide">Rénovation cuisine</p>
                                    <p class="font-semibold mt-0.5">Plomberie · Électricité</p>
                                </div>
                                <span class="text-brand font-bold">8 500 €</span>
                            </div>
                            <div class="flex items-center justify-between p-4 rounded-xl bg-gray-50 border border-gray-100">
                                <div>
                                    <p class="text-xs text-gray-500 uppercase tracking-wide">Délai moyen</p>
                                    <p class="font-semibold mt-0.5">Réponse rapide</p>
                                </div>
                                <span class="text-brand font-bold">48h</span>
                            </div>
                        </div>
                        <a href="{{ route('front.quote.create') }}"
                           class="mt-5 flex items-center justify-center w-full px-4 py-3 bg-brand text-white text-sm font-semibold rounded-xl hover:bg-brand-dark transition">
                            Estimer mon projet
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ============ BARRE RÉASSURANCE ============ --}}
    <section class="bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
                <div>
                    <p class="text-2xl font-extrabold text-white">Qualité</p>
                    <p class="text-xs text-gray-400 uppercase tracking-wide mt-1">Artisans qualifiés</p>
                </div>
                <div>
                    <p class="text-2xl font-extrabold text-white">15 ans</p>
                    <p class="text-xs text-gray-400 uppercase tracking-wide mt-1">D'expérience</p>
                </div>
                <div>
                    <p class="text-2xl font-extrabold text-white">6 corps</p>
                    <p class="text-xs text-gray-400 uppercase tracking-wide mt-1">De métier</p>
                </div>
                <div>
                    <p class="text-2xl font-extrabold text-white">500+</p>
                    <p class="text-xs text-gray-400 uppercase tracking-wide mt-1">Chantiers livrés</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ============ SERVICES ============ --}}
    <section class="bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-24">
            <div class="text-center mb-12">
                <p class="text-brand text-sm font-bold uppercase tracking-wider mb-2">Nos métiers</p>
                <h2 class="text-3xl sm:text-4xl font-extrabold tracking-tight">
                    Six corps de métier,<br>un seul interlocuteur.
                </h2>
                <p class="mt-4 text-gray-600 max-w-2xl mx-auto">
                    Plomberie, électricité, peinture, plâtrerie, menuiserie, rénovation :
                    vous coordonnez tout avec une seule équipe.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($services as $service)
                    <div class="group bg-white rounded-2xl overflow-hidden border border-gray-200 hover:border-brand hover:shadow-lg transition">
                        <div class="h-40 overflow-hidden">
                            <img src="{{ asset('images/homepage/' . $service->slug . '.jpg') }}"
                                 alt="{{ $service->name }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                        </div>
                        <div class="p-6">
                            <p class="text-xs text-brand font-bold uppercase tracking-wide mb-2">Prestation</p>
                            <h3 class="text-lg font-bold mb-2">{{ $service->name }}</h3>
                            <p class="text-sm text-gray-600 mb-4">
                                Intervention soignée par nos compagnons qualifiés, dans le respect des normes.
                            </p>
                            <a href="{{ route('front.quote.create') }}" class="text-brand text-sm font-semibold group-hover:underline">
                                En savoir plus →
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ============ TIMELINE 4 ÉTAPES ============ --}}
    <section class="bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-20">
            <div class="text-center mb-14">
                <p class="text-brand text-sm font-bold uppercase tracking-wider mb-2">Comment ça marche</p>
                <h2 class="text-3xl sm:text-4xl font-extrabold tracking-tight">
                    De la demande au chantier livré.
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                @foreach ([
                    ['01', 'Décrivez votre projet', 'Remplissez le formulaire en ligne en quelques minutes.'],
                    ['02', 'Visite technique', 'Un chargé d\'affaires évalue votre besoin sur place.'],
                    ['03', 'Devis détaillé', 'Vous recevez un devis clair, gratuit et sans engagement.'],
                    ['04', 'Chantier livré', 'Nos compagnons réalisent vos travaux dans les délais.'],
                ] as $step)
                    <div class="text-center">
                        <div class="w-14 h-14 mx-auto rounded-full bg-brand text-white flex items-center justify-center text-lg font-bold mb-4">
                            {{ $step[0] }}
                        </div>
                        <h3 class="font-bold mb-2">{{ $step[1] }}</h3>
                        <p class="text-sm text-gray-600">{{ $step[2] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ============ BLOC URGENCE ============ --}}
    <section class="bg-red-600">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
            <div class="lg:grid lg:grid-cols-2 lg:gap-12 lg:items-center">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-red-500 text-white text-xs font-semibold mb-4">
                        Intervention rapide
                    </div>
                    <h2 class="text-3xl font-extrabold text-white">Une fuite ? Une panne ? Une urgence ?</h2>
                    <p class="mt-4 text-red-100 max-w-lg">
                        Dépannage express pour les particuliers et professionnels.
                        Décrivez votre situation, nous vous rappelons sous 2h.
                    </p>
                    <ul class="mt-6 space-y-2 text-red-50 text-sm">
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            Rappel sous 2h en journée
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            Compagnons qualifiés et assurés
                        </li>
                    </ul>
                    <a href="tel:0561000000"
                       class="mt-8 inline-flex items-center gap-2 px-6 py-3.5 bg-white text-red-600 font-semibold rounded-xl hover:bg-red-50 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        05 61 00 00 00
                    </a>
                </div>

                {{-- Encart formulaire urgence --}}
                <div class="mt-10 lg:mt-0">
                    <div class="bg-white rounded-2xl p-6 max-w-md mx-auto">
                        <h3 class="font-bold text-lg mb-1">Décrivez votre urgence</h3>
                        <p class="text-sm text-gray-500 mb-4">Sélectionnez le type de problème.</p>
                        <div class="grid grid-cols-2 gap-2 mb-5">
                            @foreach (['Fuite d\'eau', 'Panne électrique', 'Serrurerie', 'Toiture', 'Chauffage'] as $chip)
                                <span class="px-3 py-2 rounded-lg border border-gray-200 text-sm text-gray-700 text-center">{{ $chip }}</span>
                            @endforeach
                        </div>
                        <a href="{{ route('front.quick.create') }}"
                           class="flex items-center justify-center w-full px-4 py-3 bg-red-600 text-white text-sm font-semibold rounded-xl hover:bg-red-700 transition">
                            Demander un dépannage
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ============ BLOC ENTREPRISE ============ --}}
    <section class="bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-20">
            <div class="lg:grid lg:grid-cols-2 lg:gap-12 lg:items-center">
                <div class="rounded-2xl h-72 overflow-hidden">
                    <img src="{{ asset('images/homepage/equipe.jpg') }}"
                         alt="Équipe SYMBIOZ"
                         class="w-full h-full object-cover">
                </div>
                <div class="mt-8 lg:mt-0">
                    <p class="text-brand text-sm font-bold uppercase tracking-wider mb-2">Notre entreprise</p>
                    <h2 class="text-3xl font-extrabold tracking-tight">
                        SYMBIOZ, une entreprise familiale au service de votre projet.
                    </h2>
                    <p class="mt-4 text-gray-600">
                        Fondée à Toulouse, SYMBIOZ est une entreprise de second œuvre indépendante.
                        Notre équipe de compagnons qualifiés intervient sur toute l'agglomération,
                        avec un souci constant de la qualité et du respect des délais.
                    </p>
                    <div class="mt-8 grid grid-cols-3 gap-6">
                        <div>
                            <p class="text-3xl font-extrabold text-brand">2</p>
                            <p class="text-xs text-gray-500 mt-1">Agences</p>
                        </div>
                        <div>
                            <p class="text-3xl font-extrabold text-brand">98%</p>
                            <p class="text-xs text-gray-500 mt-1">Satisfaction</p>
                        </div>
                        <div>
                            <p class="text-3xl font-extrabold text-brand">48h</p>
                            <p class="text-xs text-gray-500 mt-1">Réponse devis</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ============ TÉMOIGNAGES ============ --}}
    <section class="bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-20">
            <div class="text-center mb-12">
                <p class="text-brand text-sm font-bold uppercase tracking-wider mb-2">Avis clients</p>
                <h2 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Ce que disent nos clients.</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach ([
                    ['Marie L.', 'Rénovation cuisine', 'Travail impeccable et équipe très à l\'écoute. Le chantier a été livré dans les délais annoncés.'],
                    ['Thomas B.', 'Mise aux normes électriques', 'Devis clair, intervention rapide. Je recommande vivement SYMBIOZ pour leur sérieux.'],
                    ['Famille Mercier', 'Rénovation globale', 'Un seul interlocuteur pour tous nos travaux, c\'est un vrai confort. Très satisfaits du résultat.'],
                ] as $avis)
                    <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100">
                        <div class="flex gap-1 text-accent mb-4">
                            @for ($i = 0; $i < 5; $i++)
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.951a1 1 0 00.95.69h4.151c.969 0 1.371 1.24.588 1.81l-3.36 2.44a1 1 0 00-.364 1.118l1.286 3.95c.3.922-.755 1.688-1.54 1.118l-3.36-2.44a1 1 0 00-1.175 0l-3.36 2.44c-.784.57-1.838-.196-1.539-1.118l1.286-3.95a1 1 0 00-.364-1.118l-3.36-2.44c-.783-.57-.38-1.81.588-1.81h4.15a1 1 0 00.951-.69l1.286-3.951z"/></svg>
                            @endfor
                        </div>
                        <p class="text-gray-700 text-sm leading-relaxed mb-4">"{{ $avis[2] }}"</p>
                        <div>
                            <p class="font-semibold text-sm">{{ $avis[0] }}</p>
                            <p class="text-xs text-gray-500">{{ $avis[1] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ============ FAQ ACCORDÉON ============ --}}
    <section class="bg-gray-50">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-20">
            <div class="text-center mb-12">
                <p class="text-brand text-sm font-bold uppercase tracking-wider mb-2">FAQ</p>
                <h2 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Les questions qu'on nous pose souvent.</h2>
            </div>

            <div class="space-y-3" x-data="{ open: 0 }">
                @foreach ([
                    ['Le devis est-il gratuit ?', 'Oui, tous nos devis sont gratuits et sans engagement. Nous vous recontactons sous 48h ouvrées pour préciser votre projet.'],
                    ['Sous quel délai pouvez-vous intervenir ?', 'Pour un devis, sous 48h. Pour une urgence, nous vous rappelons sous 2h en journée.'],
                    ['Quelles zones couvrez-vous ?', 'Nous intervenons sur Toulouse et toute son agglomération.'],
                    ['Vos compagnons sont-ils assurés et certifiés ?', 'Oui, tous nos compagnons sont salariés, qualifiés et couverts par nos assurances professionnelles.'],
                    ['Acceptez-vous les paiements en plusieurs fois ?', 'Selon le montant du chantier, des facilités de paiement peuvent être proposées. Parlons-en lors du devis.'],
                ] as $i => $faq)
                    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                        <button @click="open === {{ $i }} ? open = null : open = {{ $i }}"
                                class="w-full flex items-center justify-between px-5 py-4 text-left font-semibold text-sm hover:bg-gray-50 transition">
                            {{ $faq[0] }}
                            <svg class="w-5 h-5 text-gray-400 transition-transform" :class="open === {{ $i }} ? 'rotate-180' : ''" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <div x-show="open === {{ $i }}" x-collapse>
                            <p class="px-5 pb-4 text-sm text-gray-600 leading-relaxed">{{ $faq[1] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

 {{-- ============ CTA FINAL ============ --}}
    <section class="bg-brand">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 text-center">
            <h2 class="text-3xl sm:text-4xl font-extrabold text-white">Un projet en tête ?</h2>
            <p class="mt-4 text-brand-light max-w-xl mx-auto">
                Décrivez-nous votre besoin, nous vous rappelons rapidement pour vous proposer une solution adaptée.
            </p>
            <div class="mt-8 flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('front.quote.create') }}"
                   class="inline-flex items-center justify-center px-6 py-3.5 bg-white text-brand font-semibold rounded-xl hover:bg-gray-100 transition">
                    Demander un devis
                </a>
                <a href="tel:0561000000"
                   class="inline-flex items-center justify-center gap-2 px-6 py-3.5 border border-white/40 text-white font-semibold rounded-xl hover:border-white transition">
                    05 61 00 00 00
                </a>
            </div>
        </div>
    </section>

@endsection
