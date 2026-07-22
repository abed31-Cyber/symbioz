{{-- Badge de priorité. Usage : <x-priority-badge :priority="$request->priority" /> --}}
@props(['priority'])

<span {{ $attributes->merge([
    'class' => 'inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold uppercase tracking-wide ' . $priority->color(),
]) }}>
    {{ $priority->label() }}
</span>
