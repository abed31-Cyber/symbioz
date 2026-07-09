@extends('layouts.public')

@section('title', 'Accueil')
@section('meta_description', 'SYMBIOZ — Artisans du BTP second œuvre à Toulouse. Plomberie, électricité, peinture, plâtrerie, menuiserie. Devis gratuit en ligne.')

@section('content')

   {{-- ===================== HERO (2 colonnes) ===================== --}}
    <section class="bg-gradient-to-br from-slate-50 to-indigo-50">
        <div class="mx-auto max-w-7xl px-4 py-16 lg:px-8 lg:py-24">
            <div class="grid grid-cols-1 items-center gap-12 lg:grid-cols-2">

                {{-- Colonne gauche --}}
                <div>
                    <span class="inline-flex items-center gap-2 rounded-full bg-indigo-100 px-3 py-1 text-xs font-semibold text-indigo-700">
                        🏅 Entreprise certifiée Qualibat · 2 ans d'expérience
                    </span>

                    <h1 class="mt-6 text-4xl font-extrabold leading-tight tracking-tight text-slate-900 sm:text-5xl">
                        Vos travaux<br>
                        <span class="text-indigo-600">entre de bonnes mains.</span>
                    </h1>

                    {{-- ⚠️ Paragraphe : ma meilleure lecture, à réajuster sur Figma si besoin --}}
                    <p class="mt-6 max-w-lg text-base leading-relaxed text-slate-600">
                        SYMBIOZ réalise vos travaux de second œuvre : plomberie,
                        électricité, peinture, plâtrerie, menuiserie pour les particuliers
                        et professionnels en Haute-Garonne. Devis sous 48h, chantier livré
                        dans les délais. Nous intervenons aussi dans les situations d'urgence, sinistre…
                    </p>

                    <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                        <a href="{{ route('front.quote-request.create') }}"
                           class="inline-flex items-center justify-center rounded-lg bg-indigo-600 px-6 py-3 text-base font-semibold text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            Demander un devis gratuit
                        </a>
                        <a href="#realisations"
                           class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-6 py-3 text-base font-semibold text-slate-700 shadow-sm hover:bg-slate-50">
                            Voir nos réalisations
                        </a>
                    </div>

                    {{-- Ligne de réassurance --}}
                    <div class="mt-6 flex flex-wrap items-center gap-x-6 gap-y-2 text-sm text-slate-500">
                        <span class="flex items-center gap-1.5">
                            <svg class="h-4 w-4 text-green-500" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true"><path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z" clip-rule="evenodd" /></svg>
                            Devis sous 48h
                        </span>
                        <span class="flex items-center gap-1.5">
                            <svg class="h-4 w-4 text-orange-500" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true"><path d="M11.983 1.907a.75.75 0 0 0-1.292-.657l-6.5 8.25a.75.75 0 0 0 .59 1.21h3.518l-.494 4.606a.75.75 0 0 0 1.292.657l6.5-8.25a.75.75 0 0 0-.59-1.21h-3.518l.494-4.606Z" /></svg>
                            Urgence : rappel sous 2h
                        </span>
                    </div>

                    {{-- Stats inline --}}
                    <div class="mt-8 flex flex-wrap gap-x-8 gap-y-3 border-t border-slate-200 pt-6">
                        <div>
                            <p class="text-xl font-bold text-slate-900">80+</p>
                            <p class="text-xs text-slate-500">chantiers livrés</p>
                        </div>
                        <div>
                            <p class="text-xl font-bold text-slate-900">98%</p>
                            <p class="text-xs text-slate-500">clients satisfaits</p>
                        </div>
                        <div>
                            <p class="text-xl font-bold text-slate-900">48h</p>
                            <p class="text-xs text-slate-500">délai de devis</p>
                        </div>
                    </div>
                </div>

                {{-- Colonne droite : carte aperçu (décorative) --}}
                <div class="relative hidden lg:block">
                    {{-- Mini-carte flottante "Chantier livré" --}}
                    <div class="absolute -top-4 right-6 z-10 flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2 shadow-md">
                        <span class="flex h-6 w-6 items-center justify-center rounded-full bg-green-100 text-green-600">✓</span>
                        <div>
                            <p class="text-xs font-semibold text-slate-900">Chantier livré</p>
                            <p class="text-[11px] text-slate-500">Famille Steven · Tournefeuille (31)</p>
                        </div>
                    </div>

                    {{-- Carte "Nouvelle demande" --}}
                    <div class="rounded-2xl border border-slate-200 bg-white p-6 pt-8 shadow-lg">
                        <div class="flex items-center justify-between">
                            <h2 class="text-sm font-semibold text-slate-900">Nouvelle demande</h2>
                            <span class="inline-flex items-center rounded-full bg-orange-100 px-2 py-0.5 text-[11px] font-bold uppercase tracking-wide text-orange-700">
                                Urgent
                            </span>
                        </div>

                        <p class="mt-3 rounded-lg bg-slate-50 p-3 text-xs leading-relaxed text-slate-600">
                            Bonjour, je souhaiterais un devis pour la rénovation complète
                            de ma salle de bain (6 m²). Douche italienne, double vasque,
                            carrelage sol et murs.
                        </p>

                        <div class="mt-5 grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-[11px] font-medium uppercase tracking-wider text-slate-400">Service</p>
                                <p class="mt-0.5 text-sm font-medium text-slate-700">Plomberie + Carrelage</p>
                            </div>
                            <div>
                                <p class="text-[11px] font-medium uppercase tracking-wider text-slate-400">Budget</p>
                                <p class="mt-0.5 text-sm font-medium text-slate-700">8 000 – 12 000 €</p>
                            </div>
                            <div>
                                <p class="text-[11px] font-medium uppercase tracking-wider text-slate-400">Localisation</p>
                                <p class="mt-0.5 text-sm font-medium text-slate-700">Tournefeuille (31)</p>
                            </div>
                            <div>
                                <p class="text-[11px] font-medium uppercase tracking-wider text-slate-400">Délai</p>
                                <p class="mt-0.5 text-sm font-medium text-slate-700">2 mois</p>
                            </div>
                        </div>

                        <div class="mt-6 flex items-center gap-2 border-t border-slate-100 pt-4 text-sm font-medium text-indigo-600">
                            → Réponse sous 2h
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ===================== BANDE STATS ===================== --}}
    <section class="bg-slate-900">
        <div class="mx-auto grid max-w-7xl grid-cols-2 gap-6 px-4 py-8 sm:grid-cols-4 lg:px-8">
            <div class="text-center">
                <p class="text-xl font-bold text-white">Qualibat</p>
                <p class="mt-1 text-xs uppercase tracking-wider text-slate-400">Certifié depuis 2026</p>
            </div>
            <div class="text-center">
                <p class="text-xl font-bold text-white">2 ans</p>
                <p class="mt-1 text-xs uppercase tracking-wider text-slate-400">D'expérience terrain</p>
            </div>
            <div class="text-center">
                <p class="text-xl font-bold text-white">6 compagnons</p>
                <p class="mt-1 text-xs uppercase tracking-wider text-slate-400">Salariés formés</p>
            </div>
            <div class="text-center">
                <p class="text-xl font-bold text-white">80+ chantiers</p>
                <p class="mt-1 text-xs uppercase tracking-wider text-slate-400">Livrés en Haute-Garonne</p>
            </div>
        </div>
    </section>

   {{-- ===================== SERVICES (6 métiers) ===================== --}}
    <section id="services" class="py-16">
        <div class="mx-auto max-w-7xl px-4 lg:px-8">
            <p class="text-center text-xs font-semibold uppercase tracking-wider text-indigo-600">Nos services</p>
            <h2 class="mt-2 text-center text-3xl font-bold tracking-tight text-slate-900">
                Six corps de métier, un seul interlocuteur.
            </h2>
            <p class="mx-auto mt-3 max-w-2xl text-center text-slate-600">
                Plomberie, électricité, peinture, plâtrerie, menuiserie : tous nos compagnons
                sont salariés et formés. Pour les projets multi-travaux, rénovations complètes,
                nous coordonnons tout.
            </p>

            <div class="mt-12 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                {{-- 5 métiers pilotés par l'enum ServiceType --}}
                @foreach ($services as $service)
                    <div class="group overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm transition hover:shadow-md">
                        <div class="flex h-44 items-center justify-center bg-slate-100 text-5xl" aria-hidden="true">
                            {{ $service->icon() }}
                        </div>
                        <div class="p-5">
                            <p class="text-[11px] font-semibold uppercase tracking-wider text-slate-400">Le problème</p>
                            <h3 class="mt-1 text-lg font-semibold text-slate-900">{{ $service->label() }}</h3>
                            {{-- ⚠️ description : celle de l'enum, ajuste sur Figma si besoin --}}
                            <p class="mt-2 text-sm text-slate-600">{{ $service->description() }}</p>
                            <a href="{{ route('front.quote-request.create') }}"
                               class="mt-3 inline-flex items-center text-sm font-semibold text-indigo-600 hover:text-indigo-700">
                                En savoir plus →
                            </a>
                        </div>
                    </div>
                @endforeach

                {{-- 6e carte : service transverse (mise en avant) --}}
                <div class="overflow-hidden rounded-xl border border-indigo-200 bg-indigo-600 shadow-sm">
                    <div class="flex h-44 items-center justify-center bg-indigo-500 text-5xl" aria-hidden="true">🏗️</div>
                    <div class="p-5">
                        <p class="text-[11px] font-semibold uppercase tracking-wider text-indigo-200">Tous corps d'état</p>
                        <h3 class="mt-1 text-lg font-semibold text-white">Pilotage complet de votre projet</h3>
                        <p class="mt-2 text-sm text-indigo-100">
                            Vous avez un appartement à rénover entièrement ? Nous coordonnons
                            tous les corps d'état (plomberie, électricité, peinture, menuiserie)
                            avec un seul interlocuteur et un seul devis.
                        </p>
                        <a href="{{ route('front.quote-request.create') }}"
                           class="mt-3 inline-flex items-center text-sm font-semibold text-white hover:text-indigo-100">
                            Demander un devis global →
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ===================== ÉTAPES (4 colonnes) ===================== --}}
    <section class="bg-slate-50 py-16">
        <div class="mx-auto max-w-7xl px-4 lg:px-8">
            <p class="text-center text-xs font-semibold uppercase tracking-wider text-indigo-600">Comment ça marche</p>
            <h2 class="mt-2 text-center text-3xl font-bold tracking-tight text-slate-900">
                De la demande au chantier livré.
            </h2>
            <p class="mx-auto mt-3 max-w-2xl text-center text-slate-600">
                Un processus simple et transparent pour vos travaux.
            </p>

            <div class="mt-12 grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-4">
                <div class="text-center">
                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-indigo-600 text-lg font-bold text-white">01</div>
                    <h3 class="mt-4 font-semibold text-slate-900">Décrivez votre projet</h3>
                    <p class="mt-2 text-sm text-slate-600">Remplissez le formulaire en ligne en quelques minutes.</p>
                    <p class="mt-2 text-xs font-medium text-indigo-600">3 minutes</p>
                </div>
                <div class="text-center">
                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-indigo-600 text-lg font-bold text-white">02</div>
                    <h3 class="mt-4 font-semibold text-slate-900">Visite technique</h3>
                    <p class="mt-2 text-sm text-slate-600">Un compagnon se déplace chez vous pour évaluer le chantier et valider les contraintes techniques.</p>
                    <p class="mt-2 text-xs font-medium text-indigo-600">Sous 48h</p>
                </div>
                <div class="text-center">
                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-indigo-600 text-lg font-bold text-white">03</div>
                    <h3 class="mt-4 font-semibold text-slate-900">Devis détaillé</h3>
                    <p class="mt-2 text-sm text-slate-600">Un devis clair ligne par ligne, sans surprise. Matériaux, main-d'œuvre, délais : tout est transparent.</p>
                    <p class="mt-2 text-xs font-medium text-indigo-600">Détaillé</p>
                </div>
                <div class="text-center">
                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-indigo-600 text-lg font-bold text-white">04</div>
                    <h3 class="mt-4 font-semibold text-slate-900">Chantier livré</h3>
                    <p class="mt-2 text-sm text-slate-600">Nos compagnons interviennent dans les délais convenus. Réception contradictoire et garantie décennale.</p>
                    <p class="mt-2 text-xs font-medium text-indigo-600">Garanti</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ===================== BANDE URGENCE (rouge) ===================== --}}
    <section class="bg-red-600">
        <div class="mx-auto max-w-7xl px-4 py-16 lg:px-8">
            <div class="grid grid-cols-1 items-center gap-8 lg:grid-cols-2">
                <div class="text-white">
                    <span class="inline-flex items-center rounded-full bg-red-500/50 px-3 py-1 text-xs font-semibold uppercase tracking-wider">
                        ⚡ Réponse en moins de deux heures
                    </span>
                    <h2 class="mt-4 text-3xl font-bold tracking-tight">Une fuite ? Une panne ? Une urgence ?</h2>
                    <p class="mt-3 max-w-lg text-red-100">
                        Décrivez votre problème en 3 minutes. Notre équipe vous rappelle et un
                        compagnon SYMBIOZ se déplace dans les meilleurs délais.
                    </p>
                    <ul class="mt-5 space-y-2 text-sm text-red-50">
                        <li class="flex items-center gap-2">✓ Dépannage 7j/7 sur Toulouse et petite couronne</li>
                        <li class="flex items-center gap-2">✓ Tarifs annoncés avant intervention</li>
                        <li class="flex items-center gap-2">✓ Nos équipes sont assurées et qualifiées</li>
                    </ul>
                    <a href="{{ route('front.quick-request.create') }}"
                       class="mt-6 inline-flex items-center gap-2 rounded-lg bg-white px-6 py-3 text-base font-semibold text-red-600 shadow-sm hover:bg-red-50">
                        📞 Décrire mon urgence
                    </a>
                </div>

                {{-- Aperçu du raccourci urgence (décoratif) --}}
                <div class="rounded-2xl bg-white p-6 shadow-lg lg:justify-self-end lg:max-w-md">
                    <p class="text-sm font-semibold text-slate-900">Décrire mon urgence</p>
                    <p class="mt-1 text-xs text-slate-500">Sélectionnez le type de problème</p>
                    <div class="mt-4 flex flex-wrap gap-2">
                        <span class="rounded-full bg-red-50 px-3 py-1.5 text-sm font-medium text-red-700">Fuite d'eau</span>
                        <span class="rounded-full bg-red-50 px-3 py-1.5 text-sm font-medium text-red-700">Panne électrique</span>
                        <span class="rounded-full bg-red-50 px-3 py-1.5 text-sm font-medium text-red-700">Serrurerie</span>
                        <span class="rounded-full bg-red-50 px-3 py-1.5 text-sm font-medium text-red-700">Toiture</span>
                        <span class="rounded-full bg-red-50 px-3 py-1.5 text-sm font-medium text-red-700">Chauffage</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

  {{-- ===================== RÉALISATIONS ===================== --}}
    <section id="realisations" class="py-16">
        <div class="mx-auto max-w-7xl px-4 lg:px-8">
            <p class="text-center text-xs font-semibold uppercase tracking-wider text-indigo-600">Nos réalisations</p>
            <h2 class="mt-2 text-center text-3xl font-bold tracking-tight text-slate-900">
                Des chantiers livrés, pas des promesses.
            </h2>
            <p class="mx-auto mt-3 max-w-2xl text-center text-slate-600">
                Cinq projets parmi les 80+ livrés en 2026. Photos non retouchées, témoignages clients vérifiés.
            </p>

            <div class="mt-12 grid grid-cols-1 gap-6 md:grid-cols-2">
                {{-- Grande réalisation --}}
                <div class="group relative overflow-hidden rounded-2xl bg-slate-200">
                    <div class="flex h-80 items-center justify-center bg-gradient-to-br from-slate-300 to-slate-400 text-4xl" aria-hidden="true">🏠</div>
                    <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/70 to-transparent p-6">
                        <span class="inline-flex rounded bg-white/90 px-2 py-0.5 text-[11px] font-semibold uppercase text-slate-800">Rénovation complète · 78 m²</span>
                        <h3 class="mt-2 text-lg font-bold text-white">Appartement Capitole</h3>
                        <p class="mt-1 text-sm text-slate-200">Tous corps d'état coordonnés, livré en 6 semaines pour la famille Drogba. Budget ~42 000 €.</p>
                    </div>
                </div>

                {{-- Colonne de petites réalisations --}}
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div class="group relative overflow-hidden rounded-2xl bg-slate-200">
                        <div class="flex h-[152px] items-center justify-center bg-gradient-to-br from-indigo-200 to-indigo-300 text-3xl" aria-hidden="true">🛁</div>
                        <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/70 to-transparent p-4">
                            <span class="inline-flex rounded bg-white/90 px-2 py-0.5 text-[10px] font-semibold uppercase text-slate-800">Salle de bain</span>
                            <h3 class="mt-1 text-sm font-bold text-white">Famille Ronaldo · Esquirol</h3>
                        </div>
                    </div>
                    <div class="group relative overflow-hidden rounded-2xl bg-slate-200">
                        <div class="flex h-[152px] items-center justify-center bg-gradient-to-br from-amber-200 to-amber-300 text-3xl" aria-hidden="true">🎨</div>
                        <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/70 to-transparent p-4">
                            <span class="inline-flex rounded bg-white/90 px-2 py-0.5 text-[10px] font-semibold uppercase text-slate-800">Peinture & sols</span>
                            <h3 class="mt-1 text-sm font-bold text-white">Bureau Avocat · Compans Caffarelli</h3>
                        </div>
                    </div>
                    <div class="group relative overflow-hidden rounded-2xl bg-slate-200">
                        <div class="flex h-[152px] items-center justify-center bg-gradient-to-br from-emerald-200 to-emerald-300 text-3xl" aria-hidden="true">🧱</div>
                        <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/70 to-transparent p-4">
                            <span class="inline-flex rounded bg-white/90 px-2 py-0.5 text-[10px] font-semibold uppercase text-slate-800">Rénovation escalier</span>
                            <h3 class="mt-1 text-sm font-bold text-white">SCI Les Lilas · La Cartoucherie</h3>
                        </div>
                    </div>
                    <div class="group relative overflow-hidden rounded-2xl bg-slate-200">
                        <div class="flex h-[152px] items-center justify-center bg-gradient-to-br from-rose-200 to-rose-300 text-3xl" aria-hidden="true">🍳</div>
                        <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/70 to-transparent p-4">
                            <span class="inline-flex rounded bg-white/90 px-2 py-0.5 text-[10px] font-semibold uppercase text-slate-800">Cuisine sur-mesure</span>
                            <h3 class="mt-1 text-sm font-bold text-white">M. & Mme Antoine Dupont · Lacroix Falgarde</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ===================== À PROPOS (entreprise familiale) ===================== --}}
    <section id="a-propos" class="bg-slate-50 py-16">
        <div class="mx-auto max-w-7xl px-4 lg:px-8">
            <div class="grid grid-cols-1 items-center gap-12 lg:grid-cols-2">
                <div class="overflow-hidden rounded-2xl bg-slate-200">
                    <div class="flex h-96 items-center justify-center bg-gradient-to-br from-indigo-300 to-slate-400 text-5xl" aria-hidden="true">👷</div>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-indigo-600">L'entreprise</p>
                    <h2 class="mt-2 text-3xl font-bold tracking-tight text-slate-900">
                        SYMBIOZ, une entreprise familiale au service de votre projet.
                    </h2>
                    <p class="mt-4 text-slate-600">
                        Fondée en 2026 par Karim, SYMBIOZ est une entreprise de second œuvre
                        indépendante basée à Toulouse. Notre équipe de 6 compagnons salariés
                        intervient quotidiennement chez les particuliers, en bureaux et en
                        commerces sur toute la Haute-Garonne.
                    </p>
                    <p class="mt-3 text-slate-600">
                        Notre engagement : un seul interlocuteur du devis à la livraison, des
                        devis détaillés et tenus, un chantier propre et respecté. Tous nos
                        compagnons sont salariés, formés et qualifiés.
                    </p>

                    <div class="mt-8 grid grid-cols-2 gap-6 sm:grid-cols-4">
                        <div>
                            <p class="text-2xl font-bold text-indigo-600">2</p>
                            <p class="text-xs text-slate-500">Compagnons salariés</p>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-indigo-600">98%</p>
                            <p class="text-xs text-slate-500">Clients satisfaits</p>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-indigo-600">80+</p>
                            <p class="text-xs text-slate-500">Chantiers réalisés</p>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-indigo-600">48h</p>
                            <p class="text-xs text-slate-500">Délai de devis</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ===================== TÉMOIGNAGES ===================== --}}
    <section id="temoignages" class="py-16">
        <div class="mx-auto max-w-7xl px-4 lg:px-8">
            <p class="text-center text-xs font-semibold uppercase tracking-wider text-indigo-600">Ils nous font confiance</p>
            <h2 class="mt-2 text-center text-3xl font-bold tracking-tight text-slate-900">
                Ce que disent nos clients.
            </h2>

            <div class="mt-12 grid grid-cols-1 gap-6 md:grid-cols-3">
                <figure class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="text-lg text-amber-400" aria-hidden="true">★★★★★</div>
                    <blockquote class="mt-3 text-sm leading-relaxed text-slate-600">
                        « SYMBIOZ a rénové notre salle de bain en 3 semaines, exactement comme
                        prévu. Équipe sérieuse, chantier propre, devis tenu au centime près.
                        Je les recommande sans hésiter. »
                    </blockquote>
                    <figcaption class="mt-4 text-sm">
                        <span class="font-semibold text-slate-900">Marie L.</span>
                        <span class="text-slate-500"> · Esquirol · Rénovation salle de bain</span>
                    </figcaption>
                </figure>
                <figure class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="text-lg text-amber-400" aria-hidden="true">★★★★★</div>
                    <blockquote class="mt-3 text-sm leading-relaxed text-slate-600">
                        « Nous avons confié à SYMBIOZ la rénovation complète de notre appartement
                        de 78 m². Coordination parfaite entre tous les corps d'état, un seul
                        interlocuteur. Livré dans les délais. »
                    </blockquote>
                    <figcaption class="mt-4 text-sm">
                        <span class="font-semibold text-slate-900">Famille Drogba</span>
                        <span class="text-slate-500"> · Capitole · Rénovation complète</span>
                    </figcaption>
                </figure>
                <figure class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="text-lg text-amber-400" aria-hidden="true">★★★★★</div>
                    <blockquote class="mt-3 text-sm leading-relaxed text-slate-600">
                        « En tant que SCI bailleresse, nous travaillons avec SYMBIOZ depuis 2 ans
                        pour la remise en état entre locataires. Réactifs, ponctuels, et toujours
                        un excellent rapport qualité-prix. »
                    </blockquote>
                    <figcaption class="mt-4 text-sm">
                        <span class="font-semibold text-slate-900">SCI Les Lilas</span>
                        <span class="text-slate-500"> · La Cartoucherie · Multi-chantiers</span>
                    </figcaption>
                </figure>
            </div>
        </div>
    </section>

    {{-- ===================== FAQ (accordéon Alpine.js) ===================== --}}
    <section id="faq" class="bg-slate-50 py-16">
        <div class="mx-auto max-w-3xl px-4 lg:px-8">
            <p class="text-center text-xs font-semibold uppercase tracking-wider text-indigo-600">FAQ</p>
            <h2 class="mt-2 text-center text-3xl font-bold tracking-tight text-slate-900">
                Les questions qu'on nous pose souvent.
            </h2>

            <div class="mt-10 space-y-3" x-data="{ open: null }">
                @foreach ([
                    ['q' => 'Le devis est-il gratuit ?', 'a' => 'Oui. Nos devis sont gratuits et sans engagement. Pour les petits travaux, nous pouvons chiffrer sur photos ; pour les chantiers plus importants, nous organisons une visite technique sur place.'],
                    ['q' => 'Sous quel délai pouvez-vous intervenir ?', 'a' => 'Pour un devis, nous vous répondons sous 48h ouvrées. Pour une urgence, un compagnon vous rappelle sous 2h ouvrées.'],
                    ['q' => 'Quelles zones couvrez-vous ?', 'a' => 'Toulouse et sa petite couronne, ainsi que l\'ensemble de la Haute-Garonne (31).'],
                    ['q' => 'Êtes-vous assurés et certifiés ?', 'a' => 'Oui. Nous sommes certifiés Qualibat et couverts par une garantie décennale. Tous nos compagnons sont salariés et assurés.'],
                    ['q' => 'Acceptez-vous les paiements en plusieurs fois ?', 'a' => 'Pour les chantiers importants, un échelonnement est possible (acompte, situations intermédiaires, solde à réception). Les modalités sont précisées sur le devis.'],
                ] as $i => $item)
                    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white">
                        <button type="button"
                                @click="open === {{ $i }} ? open = null : open = {{ $i }}"
                                :aria-expanded="open === {{ $i }}"
                                class="flex w-full items-center justify-between px-5 py-4 text-left text-sm font-semibold text-slate-900 hover:bg-slate-50">
                            {{ $item['q'] }}
                            <svg class="h-5 w-5 shrink-0 text-slate-400 transition-transform duration-200"
                                 :class="open === {{ $i }} ? 'rotate-180' : ''"
                                 fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                            </svg>
                        </button>
                        <div x-show="open === {{ $i }}" x-collapse x-cloak>
                            <p class="border-t border-slate-100 px-5 py-4 text-sm leading-relaxed text-slate-600">
                                {{ $item['a'] }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ===================== CTA FINAL ===================== --}}
    <section class="bg-slate-900">
        <div class="mx-auto max-w-4xl px-4 py-16 text-center lg:px-8">
            <h2 class="text-3xl font-bold tracking-tight text-white">Un projet en tête ?</h2>
            <p class="mx-auto mt-4 max-w-xl text-slate-300">
                Décrivez-nous votre besoin en quelques minutes. On vous rappelle rapidement
                pour préciser votre projet et organiser une visite technique si nécessaire.
            </p>
            <div class="mt-8 flex flex-col items-center justify-center gap-4 sm:flex-row">
                <a href="{{ route('front.quote-request.create') }}"
                   class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-6 py-3 text-base font-semibold text-white shadow-sm hover:bg-indigo-700">
                    Décrire mon projet →
                </a>
                <a href="tel:0784880000"
                   class="text-base font-semibold text-white hover:text-indigo-300">
                    📞 07 84 88 00 00
                </a>
            </div>
        </div>
    </section>

@endsection
