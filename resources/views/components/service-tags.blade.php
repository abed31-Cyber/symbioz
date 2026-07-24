{{-- Tags des services concernés par une demande. Usage : <x-service-tags :services="$request->services" /> --}}
@props(['services'])

<div {{ $attributes->merge(['class' => 'flex flex-wrap gap-1.5']) }}>
    @foreach ($services as $service)
        <span class="inline-flex items-center rounded-full bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-600">
            {{ $service->name }}
        </span>
    @endforeach
</div>
