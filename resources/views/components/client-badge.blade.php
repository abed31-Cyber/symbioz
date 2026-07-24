{{-- Badge prospect/client. Usage : <x-client-badge :status="$client->status" /> --}}
@props(['status'])

<span {{ $attributes->merge([
    'class' => 'inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold ' . $status->color(),
]) }}>
    {{ $status->label() }}
</span>
