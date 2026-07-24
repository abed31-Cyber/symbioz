@extends('layouts.admin')

@use('App\Enums\RequestStatus')

@section('title', 'Demandes')

@section('content')
<div class="space-y-5">

    {{-- En-tête --}}
    <div>
        <h1 class="text-2xl font-bold tracking-tight text-slate-900">Demandes</h1>
        <p class="mt-1 text-sm text-slate-500">{{ $requests->total() }} demande(s) active(s)</p>
    </div>

    {{-- Barre de recherche + filtres (soumission GET, un seul formulaire) --}}
    <form method="GET" action="{{ route('admin.requests.index') }}"
          class="flex flex-col gap-3 rounded-xl border border-slate-200 bg-white p-4 sm:flex-row sm:items-center">

        <div class="relative flex-1">
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Rechercher un nom, un email, un téléphone…"
                   class="w-full rounded-lg border border-slate-300 py-2 pl-4 pr-3 text-sm focus:border-admin focus:ring-admin">
        </div>

        <select name="status"
                class="rounded-lg border border-slate-300 py-2 pl-3 pr-8 text-sm focus:border-admin focus:ring-admin">
            <option value="">Tous les statuts</option>
            @foreach (RequestStatus::cases() as $status)
                <option value="{{ $status->value }}" @selected(request('status') === $status->value)>
                    {{ $status->label() }}
                </option>
            @endforeach
        </select>

        <select name="service"
                class="rounded-lg border border-slate-300 py-2 pl-3 pr-8 text-sm focus:border-admin focus:ring-admin">
            <option value="">Tous les services</option>
            @foreach ($services as $service)
                <option value="{{ $service->id }}" @selected((int) request('service') === $service->id)>
                    {{ $service->name }}
                </option>
            @endforeach
        </select>

        <button type="submit"
                class="rounded-lg bg-admin px-4 py-2 text-sm font-semibold text-white hover:bg-admin-dark">
            Filtrer
        </button>

        @if (request()->hasAny(['search', 'status', 'service']))
            <a href="{{ route('admin.requests.index') }}"
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
                    <th class="px-4 py-3">Référence</th>
                    <th class="px-4 py-3">Client</th>
                    <th class="px-4 py-3">Services</th>
                    <th class="px-4 py-3">Priorité</th>
                    <th class="px-4 py-3">Statut</th>
                    <th class="px-4 py-3">Reçue</th>
                    <th class="px-4 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($requests as $requestModel)
                    <tr class="hover:bg-slate-50">
                        <td class="px-4 py-3 font-medium text-slate-900">
                            {{ $requestModel->reference }}
                            @if ($requestModel->is_quick)
                                <span class="ml-1 text-xs font-semibold text-red-600">URGENTE</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-slate-700">
                            {{ trim($requestModel->client->first_name . ' ' . $requestModel->client->last_name) }}
                        </td>
                        <td class="px-4 py-3">
                            <x-service-tags :services="$requestModel->services" :limit="2" />
                        </td>
                        <td class="px-4 py-3">
                            <x-priority-badge :priority="$requestModel->priority" />
                        </td>
                        <td class="px-4 py-3">
                            <x-status-badge :status="$requestModel->status" />
                        </td>
                        <td class="px-4 py-3 text-slate-500">
                            {{ $requestModel->created_at->format('d/m/Y') }}
                        </td>
                        <td class="px-4 py-3 text-right">
                            @if (Route::has('admin.requests.show'))
                                <a href="{{ route('admin.requests.show', $requestModel) }}"
                                   class="font-semibold text-admin hover:text-admin-dark">Voir</a>
                            @else
                                <span class="text-slate-300">Voir</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-10 text-center text-slate-400">
                            Aucune demande ne correspond à votre recherche.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div>
        {{ $requests->links() }}
    </div>

</div>
@endsection
