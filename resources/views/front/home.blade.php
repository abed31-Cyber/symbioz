/**
 * Home page view
 *
 * @package resources/views/front/home.blade.php
 */
@extends('layouts.public')


/**
 * Page title and meta description
 */
@section('title', 'Accueil')

/**
 * on ajoute une meta description pour le SEO,
    car la page d'accueil est la page la plus importante du site
 */

@section('meta_description', 'SYMBIOZ — Artisans du BTP second œuvre à Toulouse. Plomberie, électricité, peinture, plâtrerie, menuiserie. Devis gratuit en ligne.')

@section('content')

    {{-- ===================== HERO ===================== --}}
    <section class="bg-gradient-to-b from-indigo-50 to-slate-50">
        <div class="mx-auto max-w-6xl px-4 py-20 text-center sm:py-28">
            <span class="inline-flex items-center rounded-full bg-indigo-100 px-3 py-1 text-sm font-medium text-indigo-700">
                Artisans du BTP second œuvre
            </span>
            <h1 class="mt-6 text-4xl font-extrabold tracking-tight text-slate-900 sm:text-5xl">
                Vos travaux, pris en main<br class="hidden sm:block"> par un artisan de confiance
            </h1>
            <p class="mx-auto mt-6 max-w-2xl text-lg text-slate-600">
                Plomberie, électricité, peinture, plâtrerie, menuiserie.
                Décrivez votre projet en 2 minutes, recevez un devis clair et sans engagement.
            </p>
            <div class="mt-10 flex flex-col items-center justify-center gap-4 sm:flex-row">
                <a href="{{ route('front.quote-request.create') }}"
                   class="w-full rounded-lg bg-indigo-600 px-6 py-3 text-base font-semibold text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto">
                    Demander un devis gratuit
                </a>
                <a href="{{ route('front.services') }}"
                   class="w-full rounded-lg bg-white px-6 py-3 text-base font-semibold text-slate-700 shadow-sm ring-1 ring-slate-200 hover:bg-slate-50 sm:w-auto">
                    Voir nos services
                </a>
            </div>
        </div>
    </section>

    {{-- ===================== SERVICES (teaser) ===================== --}}
    <section class="mx-auto max-w-6xl px-4 py-16">
        <div class="text-center">
            <h2 class="text-3xl font-bold tracking-tight text-slate-900">Nos domaines d'intervention</h2>
            <p class="mt-3 text-slate-600">Cinq métiers du second œuvre, un seul interlocuteur.</p>
        </div>

        <div class="mt-12 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
      @foreach ($services as $service)
                <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm transition hover:shadow-md">
                    <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-indigo-100 text-2xl" aria-hidden="true">
                        {{ $service->icon() }}
                    </div>
                    <h3 class="mt-4 text-lg font-semibold text-slate-900">{{ $service->label() }}</h3>
                    <p class="mt-2 text-sm text-slate-600">{{ $service->description() }}</p>
                </div>
            @endforeach
        </div>

        <div class="mt-12 text-center">
            <a href="{{ route('front.services') }}"
               class="text-sm font-semibold text-indigo-600 hover:text-indigo-700">
                Découvrir tous nos services →
            </a>
        </div>
    </section>

    {{-- ===================== ÉTAPES ===================== --}}
    <section class="bg-white">
        <div class="mx-auto max-w-6xl px-4 py-16">
            <h2 class="text-center text-3xl font-bold tracking-tight text-slate-900">Comment ça marche ?</h2>
            <div class="mt-12 grid grid-cols-1 gap-8 md:grid-cols-3">
                <div class="text-center">
                    <div class="mx-auto flex h-10 w-10 items-center justify-center rounded-full bg-indigo-600 font-bold text-white">1</div>
                    <h3 class="mt-4 font-semibold text-slate-900">Décrivez votre projet</h3>
                    <p class="mt-2 text-sm text-slate-600">Remplissez le formulaire en quelques minutes, sans créer de compte.</p>
                </div>
                <div class="text-center">
                    <div class="mx-auto flex h-10 w-10 items-center justify-center rounded-full bg-indigo-600 font-bold text-white">2</div>
                    <h3 class="mt-4 font-semibold text-slate-900">On vous recontacte</h3>
                    <p class="mt-2 text-sm text-slate-600">Réponse sous 48h pour un devis, sous 2h pour une urgence.</p>
                </div>
                <div class="text-center">
                    <div class="mx-auto flex h-10 w-10 items-center justify-center rounded-full bg-indigo-600 font-bold text-white">3</div>
                    <h3 class="mt-4 font-semibold text-slate-900">Vos travaux démarrent</h3>
                    <p class="mt-2 text-sm text-slate-600">Un devis clair, sans engagement, et un artisan qui se déplace.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ===================== CTA FINAL ===================== --}}
    <section class="bg-indigo-600">
        <div class="mx-auto max-w-4xl px-4 py-16 text-center">
            <h2 class="text-3xl font-bold tracking-tight text-white">Un projet en tête ?</h2>
            <p class="mx-auto mt-4 max-w-xl text-indigo-100">
                Obtenez votre devis gratuit dès maintenant. Aucun engagement, réponse rapide.
            </p>
            <a href="{{ route('front.quote-request.create') }}"
               class="mt-8 inline-block rounded-lg bg-white px-6 py-3 text-base font-semibold text-indigo-700 shadow-sm hover:bg-indigo-50">
                Demander mon devis
            </a>
        </div>
    </section>

@endsection
