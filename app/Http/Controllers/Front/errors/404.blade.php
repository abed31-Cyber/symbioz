@extends('layouts.public')
@include('front.errors.404')
@section('title', 'Page introuvable — SYMBIOZ')

@section('content')
<section class="bg-gray-50 py-20 lg:py-28">
    <div class="max-w-lg mx-auto px-4 sm:px-6 lg:px-8 text-center">

        <p class="text-7xl sm:text-8xl font-extrabold text-brand tracking-tight">404</p>

        <h1 class="mt-4 text-2xl sm:text-3xl font-extrabold tracking-tight">
            Cette page n'existe pas.
        </h1>
        <p class="mt-4 text-gray-600">
            La page que vous cherchez a peut-être été déplacée ou n'existe plus.
            Mais votre projet, lui, nous intéresse toujours.
        </p>

        <div class="mt-8 flex flex-col sm:flex-row gap-3 justify-center">
            <a href="{{ route('front.quote.create') }}"
               class="inline-flex items-center justify-center px-6 py-3 bg-brand text-white font-semibold rounded-xl hover:bg-brand-dark transition">
                Demander un devis
            </a>
            <a href="{{ route('front.home') }}"
               class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-gray-900 font-semibold rounded-xl hover:border-brand hover:text-brand transition">
                Retour à l'accueil
            </a>
        </div>
    </div>
</section>
@endsection
