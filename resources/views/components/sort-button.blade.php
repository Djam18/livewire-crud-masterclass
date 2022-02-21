@props(['field', 'sortField', 'sortDirection', 'label'])

<button
    wire:click="sortBy('{{ $field }}')"
    class="flex items-center gap-1 text-gray-600 uppercase text-xs font-semibold tracking-wider hover:text-gray-900 transition-colors"
>
    {{ $label }}
    <span class="{{ $sortField === $field ? 'text-indigo-500' : 'text-gray-300' }} text-sm leading-none">
        @if($sortField === $field)
            {{ $sortDirection === 'asc' ? '↑' : '↓' }}
        @else
            ↕
        @endif
    </span>
</button>
