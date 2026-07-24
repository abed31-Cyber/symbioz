@extends('layouts.admin')

@section('title', $client->first_name . ' ' . $client->last_name)

@section('content')
<div class="space-y-6">

    {{-- Fil d'ariane --}}
    <nav class="flex items-center gap-2 text-sm text-slate-500">
        <a href="{{ route('admin.clients.index') }}" class="hover:text-slate-700">Clients</a>
        <span>/</span>
        <span class="font-medium text-slate-700">{{ trim($client->first_name . ' ' . $client->last_name) }}</span>
    </nav>

    {{-- En-tête client --}}
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-4">
            <div class="flex h-14 w-14 items-center justify-center rounded-full bg-admin text-lg font-bold text-white">
                {{ Str::upper(Str::substr($client->first_name, 0, 1) . Str::substr($client->last_name, 0, 1)) }}
            </div>
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-slate-900">
                    {{ trim($client->first_name . ' ' . $client->last_name) }}
                </h1>
                <p class="mt-1 text-sm text-slate-500">
                    <x-client-badge :status="$client->status" />
                    <span class="ml-2">· {{ $client->requests->count() }} demande(s)</span>
                    <span class="ml-2">· inscrit {{ $client->created_at->translatedFormat('F Y') }}</span>
                </p>
            </div>
        </div>
    </div>

    {{-- Coordonnées (lecture seule — RG-1) --}}
    <section class="rounded-xl border border-slate-200 bg-white p-6">
        <h2 class="text-lg font-bold text-slate-900">Coordonnées</h2>
        <dl class="mt-4 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            <div>
                <dt class="text-xs font-semibold uppercase tracking-wide text-slate-400">Nom / Raison sociale</dt>
                <dd class="mt-1 text-slate-800">{{ trim($client->first_name . ' ' . $client->last_name) }}</dd>
            </div>
            <div>
                <dt class="text-xs font-semibold uppercase tracking-wide text-slate-400">Email</dt>
                <dd class="mt-1 text-slate-800">{{ $client->email ?? '—' }}</dd>
            </div>
            <div>
                <dt class="text-xs font-semibold uppercase tracking-wide text-slate-400">Téléphone</dt>
                <dd class="mt-1 text-slate-800">{{ $client->phone }}</dd>
            </div>
            <div>
                <dt class="text-xs font-semibold uppercase tracking-wide text-slate-400">Adresse</dt>
                <dd class="mt-1 text-slate-800">{{ $client->address ?? '—' }}</dd>
            </div>
            <div>
                <dt class="text-xs font-semibold uppercase tracking-wide text-slate-400">Ville</dt>
                <dd class="mt-1 text-slate-800">{{ $client->city ?? '—' }}</dd>
            </div>
        </dl>
    </section>

    {{-- Historique des demandes --}}
    <section class="rounded-xl border border-slate-200 bg-white p-6">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-bold text-slate-900">Historique des demandes</h2>
            <span class="text-sm text-slate-500">{{ $client->requests->count() }} demande(s)</span>
        </div>

        <div class="mt-4 divide-y divide-slate-100">
            @forelse ($client->requests as $requestModel)
                <div class="flex flex-col gap-2 py-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="font-semibold text-slate-900">{{ $requestModel->reference }}</span>
                            <span class="text-slate-600">{{ Str::limit($requestModel->description, 50) }}</span>
                        </div>
                        <x-service-tags :services="$requestModel->services" :limit="3" class="mt-1" />
                    </div>
                    <div class="flex items-center gap-3">
                        <x-status-badge :status="$requestModel->status" />
                        <span class="text-sm text-slate-500">{{ $requestModel->created_at->translatedFormat('d M Y') }}</span>
                        @if (Route::has('admin.requests.show'))
                            <a href="{{ route('admin.requests.show', $requestModel) }}"
                               class="text-sm font-semibold text-admin hover:text-admin-dark">Voir</a>
                        @endif
                    </div>
                </div>
            @empty
                <p class="py-8 text-center text-slate-400">Aucune demande pour ce client.</p>
            @endforelse
        </div>
    </section>

</div>
@endsection
