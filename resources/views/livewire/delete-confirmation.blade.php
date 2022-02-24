{{-- Alpine wraps the Livewire component for transitions. --}}
{{-- $wire.isOpen reads the Livewire property into Alpine's reactive world. --}}
{{-- Best pattern: Alpine = animation, Livewire = logic. --}}
<div
    x-data="{ get open() { return $wire.isOpen } }"
    x-show="open"
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/50"
    @keydown.escape.window="$wire.close()"
    style="display: none"
>
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="bg-white rounded-xl shadow-2xl w-full max-w-sm p-6"
        @click.stop
    >
        <div class="flex items-center gap-4 mb-4">
            <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <div>
                <h3 class="text-lg font-bold text-gray-900">Delete Contact</h3>
                <p class="text-sm text-gray-500">This action cannot be undone.</p>
            </div>
        </div>

        <p class="text-sm text-gray-700 mb-6">
            Are you sure you want to delete
            <strong class="text-gray-900">{{ $contactName }}</strong>?
        </p>

        <div class="flex justify-end gap-3">
            <button
                wire:click="close"
                class="px-4 py-2 text-sm text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-50"
            >
                Cancel
            </button>
            <button
                wire:click="delete"
                class="px-4 py-2 text-sm text-white bg-red-600 rounded-lg hover:bg-red-700
                       flex items-center gap-2"
            >
                <span wire:loading wire:target="delete">
                    <svg class="animate-spin h-3 w-3" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.4 0 0 5.4 0 12h4z"></path>
                    </svg>
                </span>
                Delete
            </button>
        </div>
    </div>
</div>
