{{-- Global flash component — place once in your main layout --}}
{{-- Any component: $this->emit('flash', 'Saved!', 'success') --}}
{{-- Alpine handles the animation, Livewire handles the state --}}
<div
    x-data="{ get show() { return $wire.visible } }"
    x-show="show"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 -translate-y-2"
    x-transition:enter-end="opacity-100 translate-y-0"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 translate-y-0"
    x-transition:leave-end="opacity-0 -translate-y-2"
    class="fixed top-4 left-1/2 -translate-x-1/2 z-50 min-w-72 max-w-md"
    style="display: none"
    role="alert"
    aria-live="polite"
>
    <div
        :class="{
            'bg-green-50 border-green-400 text-green-800': $wire.type === 'success',
            'bg-red-50 border-red-400 text-red-800': $wire.type === 'error',
            'bg-blue-50 border-blue-400 text-blue-800': $wire.type === 'info',
            'bg-yellow-50 border-yellow-400 text-yellow-800': $wire.type === 'warning'
        }"
        class="flex items-center gap-3 px-4 py-3 rounded-xl border-l-4 shadow-lg"
    >
        {{-- Icon by type --}}
        <span class="text-lg flex-shrink-0">
            @switch($type)
                @case('success') ✓ @break
                @case('error') ✕ @break
                @case('warning') ⚠ @break
                @default ℹ @break
            @endswitch
        </span>

        <p class="flex-1 text-sm font-medium">{{ $message }}</p>

        <button
            wire:click="dismiss"
            class="opacity-60 hover:opacity-100 text-lg leading-none ml-2"
            aria-label="Dismiss"
        >
            &times;
        </button>
    </div>
</div>
