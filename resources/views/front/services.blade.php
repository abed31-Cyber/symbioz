@extends('layouts.public')

@section('title', 'Nos services — SYMBIOZ')

@php
    // Descriptions et icônes par slug (le référentiel est figé — CDC §4.4)
    $meta = [
        'plomberie' => [
            'desc' => 'Installation, dépannage et rénovation de vos réseaux d\'eau : sanitaires, chauffe-eau, robinetterie, recherche de fuite.',
            'icon' => 'M12 2.69l5.66 5.66a8 8 0 11-11.31 0z',
        ],
        'electricite' => [
            'desc' => 'Mise aux normes, tableau électrique, installation et dépannage. Nos électriciens interviennent en toute sécurité.',
            'icon' => 'M13 2L3 14h9l-1 8 10-12h-9l1-8z',
        ],
        'peinture' => [
            'desc' => 'Peinture intérieure et extérieure, finitions soignées, préparation des supports pour un résultat impeccable.',
            'icon' => 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10',
        ],
        'platrerie' => [
            'desc' => 'Cloisons, doublages, faux plafonds, enduits. Nous façonnons vos espaces avec précision.',
            'icon' => 'M4 4h16v16H4z M4 9h16 M9 4v16',
        ],
        'menuiserie' => [
            'desc' => 'Pose et fabrication : portes, fenêtres, placards sur mesure, parquet. Le bois entre de bonnes mains.',
            'icon' => 'M3 7l9-4 9 4-9 4-9-4z M3 7v10l9 4 9-4V7',
        ],
        'renovation-globale' => [
            'desc' => 'Un interlocuteur unique pour coordonner tous les corps de métier de votre projet de rénovation complète.',
            'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6',
        ],
    ];
@endphp

@section('content')

    {{-- ===== EN-TÊTE ===== --}}
    <section class="bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-20 text-center">
            <p class="text-brand text-sm font-bold uppercase tracking-wider mb-2">Nos métiers</p>
            <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">
                Six corps de métier, un seul interlocuteur.
            </h1>
            <p class="mt-4 text-gray-600 max-w-2xl mx-auto">
                SYMBIOZ intervient dans tous les corps de métier du second œuvre,
                pour les particuliers comme pour les professionnels de l'agglomération toulousaine.
            </p>
        </div>
    </section>

    {{-- ===== GRILLE SERVICES ===== --}}
    <section class="bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-20">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($services as $service)
                    @php $m = $meta[$service->slug] ?? ['desc' => 'Intervention soignée par nos compagnons qualifiés.', 'icon' => 'M5 13l4 4L19 7']; @endphp
                    <div class="group bg-white rounded-2xl border border-gray-200 p-8 hover:border-brand hover:shadow-lg transition">
                        <div class="w-12 h-12 rounded-xl bg-brand-light flex items-center justify-center mb-5">
                            <svg class="w-6 h-6 text-brand" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $m['icon'] }}"/>
                            </svg>
                        </div>
                        <h2 class="text-xl font-bold mb-3">{{ $service->name }}</h2>
                        <p class="text-gray-600 text-sm leading-relaxed mb-6">{{ $m['desc'] }}</p>
                        <a href="{{ route('front.quote.create') }}"
                           class="text-brand font-semibold text-sm group-hover:underline">
                            Demander un devis →
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ===== BANDEAU RÉASSURANCE ===== --}}
    <section class="bg-white border-y border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-8 text-center">
                <div>
                    <h3 class="font-bold mb-1">Devis gratuit</h3>
                    <p class="text-sm text-gray-600">Réponse sous 48h ouvrées, sans engagement.</p>
                </div>
                <div>
                    <h3 class="font-bold mb-1">Compagnons qualifiés</h3>
                    <p class="text-sm text-gray-600">Salariés, assurés et formés à nos exigences.</p>
                </div>
                <div>
                    <h3 class="font-bold mb-1">Travail garanti</h3>
                    <p class="text-sm text-gray-600">Respect des normes et des délais annoncés.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== CTA ===== --}}
    <section class="bg-brand">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14 text-center">
            <h2 class="text-2xl sm:text-3xl font-extrabold text-white">Besoin d'une intervention ?</h2>
            <p class="mt-3 text-brand-light max-w-xl mx-auto">
                Décrivez votre projet, nous vous recontactons sous 48h avec un devis détaillé.
            </p>
            <div class="mt-8 flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('front.quote.create') }}"
                   class="inline-flex items-center justify-center px-6 py-3.5 bg-white text-brand font-semibold rounded-xl hover:bg-gray-100 transition">
                    Demander un devis gratuit
                </a>
                <a href="{{ route('front.quick.create') }}"
                   class="inline-flex items-center justify-center px-6 py-3.5 border border-white/40 text-white font-semibold rounded-xl hover:border-white transition">
                    Intervention urgente
                </a>
            </div>
        </div>
    </section>

@endsection
