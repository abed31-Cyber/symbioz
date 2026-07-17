@extends('layouts.public')

@section('title', 'Nos services — SYMBIOZ')

@section('content')

    <section class="bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-20">
            <div class="text-center mb-12">
                <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Nos services</h1>
                <p class="mt-3 text-gray-600 max-w-2xl mx-auto">
                    SYMBIOZ intervient dans tous les corps de métier du bâtiment, pour les particuliers et les professionnels.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($services as $service)
                    <div class="rounded-xl border border-gray-200 p-8 hover:border-brand hover:shadow-md transition">
                        <h2 class="text-xl font-bold mb-3">{{ $service->name }}</h2>
                        <p class="text-gray-600 text-sm leading-relaxed mb-6">
                            Nos compagnons qualifiés assurent une intervention rapide et un travail soigné,
                            dans le respect des normes en vigueur.
                        </p>
                        <a href="{{ route('front.quote.create') }}"
                           class="text-brand font-semibold text-sm hover:underline">
                            Demander un devis →
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="bg-brand">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 text-center">
            <h2 class="text-2xl font-extrabold text-white">Besoin d'une intervention ?</h2>
            <p class="mt-2 text-brand-light">Demande de devis gratuite, réponse sous 48h ouvrées.</p>
            <a href="{{ route('front.quote.create') }}"
               class="inline-flex items-center justify-center mt-6 px-6 py-3 bg-white text-brand font-semibold rounded-lg hover:bg-gray-100 transition">
                Demander un devis gratuit
            </a>
        </div>
    </section>

@endsection
