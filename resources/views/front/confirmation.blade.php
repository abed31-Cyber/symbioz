@extends('layouts.public')

@section('title', 'Demande envoyée — SYMBIOZ')

@section('content')
<section class="bg-gray-50 py-12 lg:py-20">
    <div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- ===== STEPPER COMPLÉTÉ ===== --}}
        <div class="flex items-center justify-center mb-10">
            <div class="flex items-center gap-2">
                <span class="w-6 h-6 rounded-full bg-brand flex items-center justify-center">
                    <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                </span>
                <span class="text-sm font-semibold">Vos infos</span>
            </div>
            <div class="w-12 h-px bg-brand mx-3"></div>
            <div class="flex items-center gap-2">
                <span class="w-6 h-6 rounded-full bg-brand flex items-center justify-center">
                    <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                </span>
                <span class="text-sm font-semibold">Projet</span>
            </div>
            <div class="w-12 h-px bg-brand mx-3"></div>
            <div class="flex items-center gap-2">
                <span class="w-6 h-6 rounded-full bg-brand text-white text-xs font-bold flex items-center justify-center">3</span>
                <span class="text-sm font-bold">Envoi</span>
            </div>
        </div>

        {{-- ===== CARTE CONFIRMATION ===== --}}
        <div class="bg-white border border-gray-200 rounded-2xl p-8 sm:p-10 shadow-sm text-center">

            {{-- Coche verte --}}
            <div class="w-20 h-20 rounded-full bg-green-100 flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
            </div>

            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight mb-3">
                Votre demande a bien été envoyée.
            </h1>

            {{-- Référence --}}
            <span class="inline-flex items-center gap-1.5 bg-brand-light text-brand text-xs font-bold tracking-wide px-4 py-1.5 rounded-full mb-6">
                Référence {{ $reference }}
            </span>

            {{-- Encart infos --}}
            <div class="bg-gray-50 border border-gray-100 rounded-xl p-5 text-left space-y-4 mb-8">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-brand flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 7v5l3 2"/></svg>
                    <span class="text-sm text-gray-700">Réponse sous <strong class="text-gray-900">48h ouvrées</strong>.</span>
                </div>
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-brand flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    <span class="text-sm text-gray-700">Un accusé de réception vous a été envoyé par email.</span>
                </div>
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-brand flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    <span class="text-sm text-gray-700">Besoin urgent ? Appelez le <strong class="text-gray-900">05 61 00 00 00</strong>.</span>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                <a href="{{ route('front.home') }}"
                   class="inline-flex items-center justify-center px-6 py-3 bg-brand text-white font-semibold rounded-xl hover:bg-brand-dark transition">
                    Retour à l'accueil
                </a>
                <a href="{{ route('front.services') }}"
                   class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-gray-900 font-semibold rounded-xl hover:border-brand hover:text-brand transition">
                    Voir nos services
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
