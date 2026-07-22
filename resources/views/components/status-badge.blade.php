{{-- Badge de statut d'une demande. Usage : <x-status-badge :status="$request->status" /> --}}
@props(['status'])

<span {{ $attributes->merge([
    'class' => 'inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold ' . $status->color(),
]) }}>
    {{ $status->label() }}
</span>
