@extends('layouts.admin')

@section('title', 'Demande ' . $requestModel->reference)

@section('content')
<div class="space-y-6">

    {{-- Fil d'ariane --}}
    <nav class="flex items-center gap-2 text-sm text-slate-500">
        <a href="{{ route('admin.requests.index') }}" class="hover:text-slate-700">Demandes</a>
        <span>/</span>
        <span class="font-medium text-slate-700">{{ $requestModel->reference }}</span>
    </nav>

    {{-- En-tête : référence + badges + source --}}
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div class="flex items-center gap-3">
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">{{ $requestModel->reference }}</h1>
            <x-status-badge :status="$requestModel->status" />
            <x-priority-badge :priority="$requestModel->priority" />
        </div>

        {{-- SOURCE : URGENTE — lecture seule, dérivé de is_quick --}}
        @if ($requestModel->is_quick)
            <span class="inline-flex items-center gap-1 rounded-lg bg-red-50 px-3 py-1.5 text-xs font-bold uppercase tracking-wide text-red-600 ring-1 ring-inset ring-red-200">
                Source : formulaire urgence
            </span>
        @else
            <span class="inline-flex items-center gap-1 rounded-lg bg-slate-100 px-3 py-1.5 text-xs font-bold uppercase tracking-wide text-slate-500">
                Source : demande de devis
            </span>
        @endif
    </div>

    <div class="grid gap-6 lg:grid-cols-3">

        {{-- Colonne principale --}}
        <div class="space-y-6 lg:col-span-2">

            {{-- Description --}}
            <section class="rounded-xl border border-slate-200 bg-white p-6">
                <h2 class="text-lg font-bold text-slate-900">Description</h2>
                <p class="mt-3 whitespace-pre-line text-slate-700">{{ $requestModel->description }}</p>

                <div class="mt-4">
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Services demandés</p>
                    <x-service-tags :services="$requestModel->services" class="mt-2" />
                </div>

                @if ($requestModel->budget_estimate)
                    <div class="mt-4">
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Budget estimé</p>
                        <p class="mt-1 text-slate-800">{{ number_format($requestModel->budget_estimate, 2, ',', ' ') }} €</p>
                    </div>
                @endif
            </section>

            {{-- Galerie photos jointes --}}
            <section class="rounded-xl border border-slate-200 bg-white p-6">
                <h2 class="text-lg font-bold text-slate-900">Photos jointes</h2>

                @if ($requestModel->photos->isNotEmpty())
                    <div class="mt-4 grid grid-cols-2 gap-3 sm:grid-cols-3">
                        @foreach ($requestModel->photos as $photo)
                            <a href="{{ Storage::url($photo->path) }}" target="_blank" rel="noopener"
                               class="group block overflow-hidden rounded-lg border border-slate-200">
                                <img src="{{ Storage::url($photo->path) }}"
                                     alt="Photo de la demande {{ $requestModel->reference }}"
                                     class="h-32 w-full object-cover transition group-hover:scale-105"
                                     loading="lazy">
                            </a>
                        @endforeach
                    </div>
                @else
                    <p class="mt-4 text-sm text-slate-400">Aucune photo jointe à cette demande.</p>
                @endif
            </section>

            {{-- Emplacement du formulaire de statut (US-4.2) --}}
            {{-- Pilotage : statut, priorité, notes (RG-2, RG-11) --}}
            <section class="rounded-xl border border-slate-200 bg-white p-6"
                     x-data="{ status: '{{ old('status', $requestModel->status->value) }}' }">
                <h2 class="text-lg font-bold text-slate-900">Pilotage de la demande</h2>

                @if (session('success'))
                    <div class="mt-3 rounded-lg bg-green-50 px-4 py-2 text-sm font-medium text-green-700">
                        {{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.requests.update', $requestModel) }}" class="mt-4 space-y-4">
                    @csrf
                    @method('PATCH')

                    <div class="grid gap-4 sm:grid-cols-2">
                        {{-- Statut --}}
                        <div>
                            <label for="status" class="block text-sm font-medium text-slate-700">Statut</label>
                            <select name="status" id="status" x-model="status"
                                    class="mt-1 w-full rounded-lg border-slate-300 text-sm focus:border-admin focus:ring-admin">
                                @foreach (\App\Enums\RequestStatus::cases() as $status)
                                    <option value="{{ $status->value }}" @selected(old('status', $requestModel->status->value) === $status->value)>
                                        {{ $status->label() }}
                                    </option>
                                @endforeach
                            </select>
                            @error('status') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        {{-- Priorité (RG-11 : modifiable) --}}
                        <div>
                            <label for="priority" class="block text-sm font-medium text-slate-700">Priorité</label>
                            <select name="priority" id="priority"
                                    class="mt-1 w-full rounded-lg border-slate-300 text-sm focus:border-admin focus:ring-admin">
                                @foreach (\App\Enums\RequestPriority::cases() as $priority)
                                    <option value="{{ $priority->value }}" @selected(old('priority', $requestModel->priority->value) === $priority->value)>
                                        {{ $priority->label() }}
                                    </option>
                                @endforeach
                            </select>
                            @error('priority') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    {{-- Raison de clôture : visible seulement si statut = perdu (RG-2) --}}
                    <div x-show="status === '{{ \App\Enums\RequestStatus::PERDU->value }}'" x-cloak>
                        <label for="closing_reason" class="block text-sm font-medium text-slate-700">
                            Raison de la perte <span class="text-red-600">*</span>
                        </label>
                        <input type="text" name="closing_reason" id="closing_reason"
                               value="{{ old('closing_reason', $requestModel->closing_reason) }}"
                               placeholder="Ex. budget trop élevé, a choisi un concurrent…"
                               class="mt-1 w-full rounded-lg border-slate-300 text-sm focus:border-admin focus:ring-admin">
                        @error('closing_reason') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- Notes internes (dont RDV téléphonique — ADR-011) --}}
                    <div>
                        <label for="admin_notes" class="block text-sm font-medium text-slate-700">
                            Notes internes
                        </label>
                        <textarea name="admin_notes" id="admin_notes" rows="4"
                                  placeholder="Compte-rendu d'appel, RDV convenu par téléphone, remarques…"
                                  class="mt-1 w-full rounded-lg border-slate-300 text-sm focus:border-admin focus:ring-admin">{{ old('admin_notes', $requestModel->admin_notes) }}</textarea>
                        @error('admin_notes') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <button type="submit"
                            class="rounded-lg bg-admin px-5 py-2.5 text-sm font-semibold text-white hover:bg-admin-dark">
                        Enregistrer
                    </button>
                </form>
            </section>

            {{-- Archivage (RG-3) — confirmation Alpine avant soft delete --}}
            <section class="rounded-xl border border-red-100 bg-red-50 p-6"
                     x-data="{ confirmOpen: false }">
                <h2 class="text-sm font-bold uppercase tracking-wide text-red-700">Zone d'archivage</h2>
                <p class="mt-1 text-sm text-slate-600">
                    Archiver retire la demande du pipeline actif. Elle reste consultable dans les archives et peut être restaurée.
                </p>

                <button type="button" @click="confirmOpen = true"
                        class="mt-4 rounded-lg border border-red-300 bg-white px-4 py-2 text-sm font-semibold text-red-700 hover:bg-red-100">
                    Archiver cette demande
                </button>

                {{-- Confirmation inline --}}
                <div x-show="confirmOpen" x-cloak class="mt-4 rounded-lg border border-red-200 bg-white p-4">
                    <p class="text-sm font-medium text-slate-800">Confirmer l'archivage de {{ $requestModel->reference }} ?</p>
                    <div class="mt-3 flex gap-2">
                        <form method="POST" action="{{ route('admin.requests.archive', $requestModel) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white hover:bg-red-700">
                                Oui, archiver
                            </button>
                        </form>
                        <button type="button" @click="confirmOpen = false"
                                class="rounded-lg px-4 py-2 text-sm font-medium text-slate-500 hover:text-slate-700">
                            Annuler
                        </button>
                    </div>
                </div>
            </section>

        </div>

        {{-- Colonne latérale : client --}}
        <div class="space-y-6">
            <section class="rounded-xl border border-slate-200 bg-white p-6">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-bold text-slate-900">Client</h2>
                    <x-client-badge :status="$requestModel->client->status" />
                </div>

                <dl class="mt-4 space-y-3 text-sm">
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wide text-slate-400">Nom / Raison sociale</dt>
                        <dd class="mt-0.5 text-slate-800">
                            {{ trim($requestModel->client->first_name . ' ' . $requestModel->client->last_name) }}
                        </dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wide text-slate-400">Email</dt>
                        <dd class="mt-0.5 text-slate-800">{{ $requestModel->client->email ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wide text-slate-400">Téléphone</dt>
                        <dd class="mt-0.5 text-slate-800">{{ $requestModel->client->phone }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wide text-slate-400">Ville</dt>
                        <dd class="mt-0.5 text-slate-800">{{ $requestModel->client->city ?? '—' }}</dd>
                    </div>
                </dl>

                <a href="{{ route('admin.clients.show', $requestModel->client) }}"
                   class="mt-4 inline-block text-sm font-semibold text-admin hover:text-admin-dark">
                    Voir la fiche client →
                </a>
            </section>

            {{-- Méta --}}
            <section class="rounded-xl border border-slate-200 bg-white p-6 text-sm">
                <div class="flex justify-between">
                    <span class="text-slate-500">Reçue le</span>
                    <span class="font-medium text-slate-800">{{ $requestModel->created_at->translatedFormat('d M Y') }}</span>
                </div>
            </section>
        </div>

    </div>
</div>
@endsection
