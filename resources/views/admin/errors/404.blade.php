@extends('layouts.admin')

@section('title', 'Page non trouvée')

@section('content')
<div class="flex flex-col items-center justify-center py-24 text-center">
    <p class="text-8xl font-extrabold text-red-600">404</p>

    <h1 class="mt-4 text-xl font-bold text-gray-900">Page non trouvée</h1>

    <p class="mt-2 text-gray-600 max-w-sm">
        La page que vous recherchez n'existe pas ou a été déplacée.
    </p>

    <a href="{{ route('admin.dashboard') }}"
       class="mt-6 inline-flex items-center gap-2 px-6 py-3 bg-admin text-white font-semibold rounded-xl hover:bg-admin-dark transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 12H5M11 18l-6-6 6-6"/></svg>
        Retour au tableau de bord
    </a>
</div>
@endsection
