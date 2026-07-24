@extends('layouts.admin')

@section('title', 'Clients')

@section('content')
<div class="space-y-5">

    {{-- En-tête --}}
    <div>
        <h1 class="text-2xl font-bold tracking-tight text-slate-900">Clients</h1>
        <p class="mt-1 text-sm text-slate-500">{{ $clients->total() }} client(s)</p>
    </div>

    {{-- Recherche --}}
    <form method="GET" action="{{ route('admin.clients.index') }}"
          class="flex flex-col gap-3 rounded-xl border border-slate-200 bg-white p-4 sm:flex-row sm:items-center">
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Rechercher un nom, une ville…"
               class="flex-1 rounded-lg border border-slate-300 py-2 px-4 text-sm focus:border-admin focus:ring-admin">
        <button type="submit"
                class="rounded-lg bg-admin px-4 py-2 text-sm font-semibold text-white hover:bg-admin-dark">
            Rechercher
        </button>
        @if (request('search'))
            <a href="{{ route('admin.clients.index') }}"
               class="rounded-lg px-3 py-2 text-sm font-medium text-slate-500 hover:text-slate-700">
                Réinitialiser
            </a>
        @endif
    </form>

    {{-- Tableau --}}
    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white">
        <table class="min-w-full divide-y divide-slate-200 text-sm">
            <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                <tr>
                    <th class="px-4 py-3">Nom / Raison sociale</th>
                    <th class="px-4 py-3">Ville</th>
                    <th class="px-4 py-3">Téléphone</th>
                    <th class="px-4 py-3">Type</th>
                    <th class="px-4 py-3">Demandes</th>
                    <th class="px-4 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($clients as $client)
                    <tr class="hover:bg-slate-50">
                        <td class="px-4 py-3 font-medium text-slate-900">
                            {{ trim($client->first_name . ' ' . $client->last_name) }}
                        </td>
                        <td class="px-4 py-3 text-slate-600">{{ $client->city ?? '—' }}</td>
                        <td class="px-4 py-3 text-slate-600">{{ $client->phone }}</td>
                        <td class="px-4 py-3">
                          <x-client-badge :status="$client->status" />
                        </td>
                        <td class="px-4 py-3 text-slate-700">{{ $client->requests_count }}</td>
                        <td class="px-4 py-3 text-right">
                            @if (Route::has('admin.clients.show'))
                                <a href="{{ route('admin.clients.show', $client) }}"
                                   class="font-semibold text-admin hover:text-admin-dark">Voir</a>
                            @else
                                <span class="text-slate-300">Voir</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-10 text-center text-slate-400">
                            Aucun client ne correspond à votre recherche.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div>{{ $clients->links() }}</div>

</div>
@endsection
