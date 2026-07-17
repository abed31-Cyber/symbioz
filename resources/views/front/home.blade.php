@extends('layouts.public')

@section('title', 'SYMBIOZ — Votre partenaire bâtiment à Toulouse')

@section('content')

    {{-- ===== HERO ===== --}}
    <section class="bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-24">
            <div class="lg:grid lg:grid-cols-2 lg:gap-12 items-center">
                <div>
                    <h1 class="text-4xl sm:text-5xl font-extrabold tracking-tight leading-tight">
                        Votre partenaire <span class="text-brand">bâtiment</span> à Toulouse
                    </h1>
                    <p class="mt-5 text-lg text-gray-600 leading-relaxed max-w-xl">
                        Plomberie, électricité, peinture, plâtrerie, menuiserie et rénovation globale.
                        Nos équipes qualifiées interviennent pour les particuliers et professionnels dans toute l'agglomération toulousaine.
                    </p>
                    <div class="mt-8 flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('front.quote.create') }}"
                           class="inline-flex items-center justify-center px-6 py-3 bg-brand text-white font-semibold rounded-lg hover:bg-brand-dark transition">
                            Demander un devis
                        </a>
                        <a href="{{ route('front.quick.create') }}"
                           class="inline-flex items-center justify-center px-6 py-3 border-2 border-red-500 text-red-600 font-semibold rounded-lg hover:bg-red-50 transition">
                            Intervention urgente
                        </a>
                    </div>
                </div>
                <div class="hidden lg:block">
                    <div class="bg-gray-200 rounded-2xl h-80 flex items-center justify-center text-gray-500">
                        {{-- Placeholder image — à remplacer par une vraie photo --}}
                        <span class="text-sm">Photo chantier</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== CHIFFRES CLÉS ===== --}}
    <section class="border-y border-gray-200 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-8 text-center">
                <div>
                    <p class="text-4xl font-extrabold text-brand">15<span class="text-accent">+</span></p>
                    <p class="mt-1 text-sm text-gray-600">Années d'expérience</p>
                </div>
                <div>
                    <p class="text-4xl font-extrabold text-brand">500<span class="text-accent">+</span></p>
                    <p class="mt-1 text-sm text-gray-600">Chantiers réalisés</p>
                </div>
                <div>
                    <p class="text-4xl font-extrabold text-brand">98<span class="text-accent">%</span></p>
                    <p class="mt-1 text-sm text-gray-600">Clients satisfaits</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== SERVICES ===== --}}
    <section class="bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-20">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-extrabold tracking-tight">Nos services</h2>
                <p class="mt-3 text-gray-600 max-w-2xl mx-auto">
                    Des solutions complètes pour tous vos travaux de rénovation et d'entretien.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($services as $service)
                    <div class="bg-white rounded-xl p-6 border border-gray-200 hover:border-brand hover:shadow-md transition">
                        <h3 class="text-lg font-bold mb-2">{{ $service->name }}</h3>
                        <p class="text-sm text-gray-600">
                            Intervention rapide et travail soigné par nos compagnons qualifiés.
                        </p>
                    </div>
                @endforeach
            </div>

            <div class="text-center mt-10">
                <a href="{{ route('front.services') }}" class="text-brand font-semibold hover:underline">
                    Découvrir tous nos services →
                </a>
            </div>
        </div>
    </section>

    {{-- ===== CTA FINAL ===== --}}
    <section class="bg-brand">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 text-center">
            <h2 class="text-3xl font-extrabold text-white">Un projet ? Parlons-en.</h2>
            <p class="mt-3 text-brand-light max-w-xl mx-auto">
                Décrivez votre besoin et nous vous rappelons sous 48h ouvrées pour vous proposer un devis détaillé.
            </p>
            <div class="mt-8 flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('front.quote.create') }}"
                   class="inline-flex items-center justify-center px-6 py-3 bg-white text-brand font-semibold rounded-lg hover:bg-gray-100 transition">
                    Demander un devis gratuit
                </a>
                <a href="{{ route('front.quick.create') }}"
                   class="inline-flex items-center justify-center px-6 py-3 border-2 border-white text-white font-semibold rounded-lg hover:bg-brand-dark transition">
                    Intervention urgente
                </a>
            </div>
        </div>
    </section>

@endsection
