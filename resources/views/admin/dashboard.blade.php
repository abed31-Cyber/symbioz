@extends('layouts.admin')

@use('App\Enums\RequestStatus')

@section('title', 'Tableau de bord')

@section('content')


<div class="space-y-6">

    {{-- En-tête --}}
    <div>
        <h1 class="text-2xl font-bold tracking-tight text-slate-900">
            Bonjour {{ auth()->user()->name }}.
        </h1>
        <p class="mt-1 text-sm text-slate-500">
            {{ ucfirst(now()->translatedFormat('l j F')) }} ·
            <strong class="font-semibold text-slate-700">{{ $countsByStatus[RequestStatus::NOUVEAU->value] }}</strong>
            demande(s) en attente de traitement.
        </p>
    </div>

    {{-- Alerte « à traiter en priorité » --}}
    @if ($urgentRequest)
        <div class="flex flex-col gap-4 rounded-xl border border-red-200 bg-red-50 p-5 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-wide text-red-600">À traiter en priorité</p>
                <p class="mt-1 font-semibold text-slate-900">
                    {{ trim($urgentRequest->client->first_name . ' ' . $urgentRequest->client->last_name) }}
                    · {{ Str::limit($urgentRequest->description, 60) }}
                </p>
                <p class="mt-1 text-sm text-slate-600">
                    {{ $urgentRequest->reference }} ·
                    reçue {{ $urgentRequest->created_at->diffForHumans() }}
                    @if ($urgentRequest->client->city) · {{ $urgentRequest->client->city }} @endif
                </p>
                <x-service-tags :services="$urgentRequest->services" class="mt-2" />
            </div>

            @if (Route::has('admin.requests.show'))
                <a href="{{ route('admin.requests.show', $urgentRequest) }}"
                   class="inline-flex shrink-0 items-center justify-center rounded-lg bg-red-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-red-700">
                    Voir la demande
                </a>
            @endif
        </div>
    @endif

    {{-- KPI --}}
    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-xl border border-slate-200 bg-white p-5">
            <p class="text-xs font-bold uppercase tracking-wide text-slate-400">CA potentiel</p>
            <p class="mt-3 text-3xl font-extrabold tracking-tight text-slate-900">
                {{ number_format($pipelineRevenue, 0, ',', ' ') }} €
            </p>
            <p class="mt-1 text-sm text-slate-500">Budgets estimés des demandes ouvertes</p>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-5">
            <p class="text-xs font-bold uppercase tracking-wide text-slate-400">Demandes actives</p>
            <p class="mt-3 text-3xl font-extrabold tracking-tight text-slate-900">{{ $activeTotal }}</p>
            <p class="mt-1 text-sm text-slate-500">Hors archives</p>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-5">
            <p class="text-xs font-bold uppercase tracking-wide text-slate-400">Demandes ce mois</p>
            <p class="mt-3 text-3xl font-extrabold tracking-tight text-slate-900">{{ $requestsThisMonth }}</p>
            <p class="mt-1 text-sm text-slate-500">Depuis le 1er du mois</p>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-5">
            <p class="text-xs font-bold uppercase tracking-wide text-slate-400">Taux de traitement</p>
            <p class="mt-3 text-3xl font-extrabold tracking-tight text-slate-900">{{ $processingRate }} %</p>
            <p class="mt-1 text-sm text-slate-500">Traités / (traités + perdus)</p>
        </div>
    </div>

    {{-- Pipeline commercial --}}
    <div class="rounded-xl border border-slate-200 bg-white p-6">
        <h2 class="text-lg font-bold text-slate-900">Pipeline commercial</h2>
        <p class="mt-1 text-sm text-slate-500">Répartition des demandes actives par statut.</p>

        <div class="mt-5 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            @foreach (RequestStatus::cases() as $status)
                <div class="rounded-lg border border-slate-200 p-4">
                    <div class="flex items-center justify-between">
                        <x-status-badge :status="$status" />
                        <span class="text-2xl font-extrabold text-slate-900">
                            {{ $countsByStatus[$status->value] }}
                        </span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

</div>
@endsection
