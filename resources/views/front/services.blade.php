@extends('layouts.public')

@section('title', 'Nos services')
@section('meta_description', 'Plomberie, électricité, peinture, plâtrerie, menuiserie : découvrez les services de second œuvre SYMBIOZ à Toulouse.')

@section('content')

    {{-- En-tête --}}
    <section class="bg-gradient-to-br from-slate-50 to-indigo-50">
        <div class="mx-auto max-w-4xl px-4 py-16 text-center lg:px-8 lg:py-20">
            <p class="text-xs font-semibold uppercase tracking-wider text-indigo-600">Nos services</p>
            <h1 class="mt-2 text-4xl font-extrabold tracking-tight text-slate-900 sm:text-5xl">
                Six corps de métier, un seul interlocuteur.
            </h1>
            <p class="mx-auto mt-4 max-w-2xl text-lg text-slate-600">
                Tous nos compagnons sont salariés et formés. Pour un dépannage ou une
                rénovation complète, vous ne gérez qu'un seul chantier et un seul devis.
            </p>
            <a href="{{ route('front.quote-request.create') }}"
               class="mt-8 inline-flex items-center justify-center rounded-lg bg-indigo-600 px-6 py-3 text-base font-semibold text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                Demander un devis gratuit →
            </a>
        </div>
    </section>

    {{-- Liste détaillée des 5 métiers (pilotée par l'enum) --}}
    <section class="py-16">
        <div class="mx-auto max-w-6xl space-y-12 px-4 lg:px-8">
            @foreach ($services as $service)
                <article class="grid grid-cols-1 items-center gap-8 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm md:grid-cols-2 md:gap-12 md:p-8">
                    {{-- Visuel (placeholder tant que les photos ne sont pas déposées) --}}
                    <div class="flex h-56 items-center justify-center rounded-xl bg-slate-100 text-6xl {{ $loop->even ? 'md:order-2' : '' }}"
                         aria-hidden="true">
                        {{ $service->icon() }}
                    </div>

                    {{-- Contenu --}}
                    <div class="{{ $loop->even ? 'md:order-1' : '' }}">
                        <p class="text-xs font-semibold uppercase tracking-wider text-indigo-600">
                            {{ $service->label() }}
                        </p>
                        <h2 class="mt-1 text-2xl font-bold tracking-tight text-slate-900">
                            {{ $service->tagline() }}
                        </h2>
                        <p class="mt-3 text-slate-600">{{ $service->description() }}</p>

                        <ul class="mt-5 space-y-2">
                            @foreach ($service->prestations() as $prestation)
                                <li class="flex items-start gap-2 text-sm text-slate-700">
                                    <svg class="mt-0.5 h-4 w-4 shrink-0 text-green-500" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true"><path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z" clip-rule="evenodd" /></svg>
                                    {{ $prestation }}
                                </li>
                            @endforeach
                        </ul>

                        <a href="{{ route('front.quote-request.create') }}"
                           class="mt-6 inline-flex items-center text-sm font-semibold text-indigo-600 hover:text-indigo-700">
                            Demander un devis {{ $service->label() }} →
                        </a>
                    </div>
                </article>
            @endforeach
        </div>
    </section>

    {{-- CTA final --}}
    <section class="bg-slate-900">
        <div class="mx-auto max-w-4xl px-4 py-16 text-center lg:px-8">
            <h2 class="text-3xl font-bold tracking-tight text-white">Un projet multi-travaux ?</h2>
            <p class="mx-auto mt-4 max-w-xl text-slate-300">
                On coordonne tous les corps d'état avec un seul interlocuteur.
                Décrivez votre projet, on vous rappelle sous 48h.
            </p>
            <a href="{{ route('front.quote-request.create') }}"
               class="mt-8 inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-6 py-3 text-base font-semibold text-white shadow-sm hover:bg-indigo-700">
                Décrire mon projet →
            </a>
        </div>
    </section>

@endsection
