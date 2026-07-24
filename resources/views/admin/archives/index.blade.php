@extends('layouts.admin')

@section('title', 'Archives')

@section('content')
<div class="space-y-5">

    {{-- En-tête --}}
    <div>
        <h1 class="text-2xl font-bold tracking-tight text-slate-900">Archives des demandes</h1>
        <p class="mt-1 text-sm text-slate-500">Historique des demandes traitées ou perdues, archivées.</p>
    </div>

    {{-- Flash --}}
    @if (session('success'))
        <div class="rounded-lg bg-green-50 px-4 py-2 text-sm font-medium text-green-700">
            {{ session('success') }}
        </div>
    @endif

    {{-- KPI --}}
    <div class="grid gap-4 sm:grid-cols-3">
        <div class="rounded-xl border border-slate-200 bg-white p-5">
            <p class="text-3xl font-extrabold text-slate-900">{{ $kpi['total'] }}</p>
            <p class="mt-1 text-sm text-slate-500">Total archivé</p>
        </div>
        <div class="rounded-xl border border-slate-200 bg-white p-5">
            <p class="text-3xl font-extrabold text-green-700">{{ $kpi['traite'] }}</p>
            <p class="mt-1 text-sm text-slate-500">Traité</p>
        </div>
        <div class="rounded-xl border border-slate-200 bg-white p-5">
            <p class="text-3xl font-extrabold text-red-700">{{ $kpi['perdu'] }}</p>
            <p class="mt-1 text-sm text-slate-500">Perdus</p>
        </div>
    </div>

    {{-- Recherche --}}
    <form method="GET" action="{{ route('admin.archives.index') }}"
          class="flex flex-col gap-3 rounded-xl border border-slate-200 bg-white p-4 sm:flex-row sm:items-center">
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Rechercher un client, une ville…"
               class="flex-1 rounded-lg border border-slate-300 py-2 px-4 text-sm focus:border-admin focus:ring-admin">
        <button type="submit"
                class="rounded-lg bg-admin px-4 py-2 text-sm font-semibold text-white hover:bg-admin-dark">
            Rechercher
        </button>
    </form>

    {{-- Table --}}
    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white">
        <table class="min-w-full divide-y divide-slate-200 text-sm">
            <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                <tr>
                    <th class="px-4 py-3">Client</th>
                    <th class="px-4 py-3">Services</th>
                    <th class="px-4 py-3">Statut</th>
                    <th class="px-4 py-3">Raison</th>
                    <th class="px-4 py-3">Archivée</th>
                    <th class="px-4 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($archives as $requestModel)
                    <tr class="hover:bg-slate-50" x-data="{ confirmDelete: false }">
                        <td class="px-4 py-3 font-medium text-slate-900">
                            {{ trim($requestModel->client->first_name . ' ' . $requestModel->client->last_name) }}
                            <span class="block text-xs font-normal text-slate-400">{{ $requestModel->client->city ?? '—' }}</span>
                        </td>
                        <td class="px-4 py-3">
                            <x-service-tags :services="$requestModel->services" :limit="2" />
                        </td>
                        <td class="px-4 py-3">
                            <x-status-badge :status="$requestModel->status" />
                        </td>
                        <td class="px-4 py-3 text-slate-500">{{ $requestModel->closing_reason ?? '—' }}</td>
                        <td class="px-4 py-3 text-slate-500">{{ $requestModel->deleted_at->translatedFormat('d M Y') }}</td>
                        <td class="px-4 py-3">
                            <div class="flex items-center justify-end gap-2">
                                {{-- Restaurer --}}
                                <form method="POST" action="{{ route('admin.archives.restore', $requestModel->id) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="font-semibold text-admin hover:text-admin-dark">Restaurer</button>
                                </form>

                                {{-- Supprimer définitivement — double confirmation --}}
                                <button type="button" @click="confirmDelete = true"
                                        class="font-semibold text-red-600 hover:text-red-700">Suppr. déf.</button>

                                <div x-show="confirmDelete" x-cloak
                                     class="flex items-center gap-2">
                                    <span class="text-xs text-slate-500">Sûr ?</span>
                                    <form method="POST" action="{{ route('admin.archives.destroy', $requestModel->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="rounded bg-red-600 px-2 py-1 text-xs font-semibold text-white hover:bg-red-700">
                                            Oui
                                        </button>
                                    </form>
                                    <button type="button" @click="confirmDelete = false"
                                            class="text-xs text-slate-400 hover:text-slate-600">Non</button>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-10 text-center text-slate-400">Aucune demande archivée.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div>{{ $archives->links() }}</div>

</div>
@endsection
