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
    {{-- TODO : prochaine itération --}}
    <section class="py-16">
        <div class="mx-auto max-w-7xl px-4 lg:px-8">
            <p class="text-center text-xs font-semibold uppercase tracking-wider text-indigo-600">Nos expertises</p>
            <h2 class="mt-2 text-center text-3xl font-bold tracking-tight text-slate-900">Six corps de métier, un seul interlocuteur.</h2>
            <p class="mx-auto mt-3 max-w-2xl text-center text-slate-600">
                Plomberie, électricité, gaz, carrelage, peinture : tous vos intervenants sont salariés chez nous.
                En clair, vous ne gérez qu'un seul chantier, qu'un seul devis, qu'un seul planning.
            </p>

            <div class="mt-12 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($services as $service)
                    <div class="group overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm transition hover:shadow-md">
                        {{-- Placeholder image --}}
                        <div class="flex h-48 items-center justify-center bg-slate-100 text-5xl" aria-hidden="true">
                            {{ $service->icon() }}
                        </div>
                        <div class="p-5">
                            <h3 class="text-lg font-semibold text-slate-900">{{ $service->label() }}</h3>
                            <p class="mt-2 text-sm text-slate-600">{{ $service->description() }}</p>
                            <a href="{{ route('front.services') }}"
                               class="mt-3 inline-flex items-center text-sm font-semibold text-indigo-600 hover:text-indigo-700">
                                En savoir plus →
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ===================== ÉTAPES (4 colonnes) ===================== --}}
    {{-- TODO : prochaine itération --}}

    {{-- ===================== BANDE URGENCE (rouge/orange) ===================== --}}
    {{-- TODO : prochaine itération --}}

    {{-- ===================== RÉALISATIONS ===================== --}}
    {{-- TODO : prochaine itération --}}

    {{-- ===================== À PROPOS (entreprise familiale) ===================== --}}
    {{-- TODO : prochaine itération --}}

    {{-- ===================== TÉMOIGNAGES ===================== --}}
    {{-- TODO : prochaine itération --}}

    {{-- ===================== FAQ (accordéon Alpine.js) ===================== --}}
    {{-- TODO : prochaine itération --}}

    {{-- ===================== CTA FINAL ===================== --}}
    {{-- TODO : prochaine itération --}}

@endsection
