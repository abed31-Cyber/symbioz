@extends('layouts.public')

@section('title', 'Page introuvable')

@section('content')
<div class="mx-auto max-w-lg px-4 py-20 text-center">
    <p class="text-6xl font-extrabold text-brand">404</p>
    <h1 class="mt-4 text-2xl font-bold text-slate-900">Page introuvable</h1>
    <p class="mt-2 text-slate-500">La page que vous cherchez n'existe pas ou a été déplacée.</p>
    <a href="{{ route('front.home') }}"
       class="mt-6 inline-block rounded-lg bg-brand px-5 py-2.5 text-sm font-semibold text-white hover:bg-brand-dark">
        Retour à l'accueil
    </a>
</div>
@endsection
