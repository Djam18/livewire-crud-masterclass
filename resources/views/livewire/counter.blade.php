<div class="max-w-sm mx-auto bg-white rounded-xl shadow-lg p-8 text-center">
    <h2 class="text-xl font-bold text-gray-800 mb-2">Livewire Counter</h2>
    <p class="text-sm text-gray-500 mb-6">
        State lives on the server. PHP manages it. Mind = blown.
    </p>

    {{-- Le count vit dans $this->count côté PHP --}}
    {{-- wire:click envoie une requête Ajax, PHP répond, Livewire patch le DOM --}}
    <div class="text-6xl font-mono font-bold text-indigo-600 mb-8">
        {{ $count }}
    </div>

    <div class="flex items-center justify-center gap-4">
        <button
            wire:click="decrement"
            class="w-12 h-12 rounded-full bg-red-100 text-red-600 text-2xl font-bold
                   hover:bg-red-200 transition-colors focus:outline-none focus:ring-2
                   focus:ring-red-400"
        >
            −
        </button>

        <button
            wire:click="reset"
            class="px-4 py-2 text-sm text-gray-500 hover:text-gray-700
                   border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors"
        >
            Reset
        </button>

        <button
            wire:click="increment"
            class="w-12 h-12 rounded-full bg-green-100 text-green-600 text-2xl font-bold
                   hover:bg-green-200 transition-colors focus:outline-none focus:ring-2
                   focus:ring-green-400"
        >
            +
        </button>
    </div>

    {{-- wire:loading shows during the Ajax round-trip --}}
    {{-- In React I'd manage this with useState + useEffect. Here: built-in. --}}
    <div wire:loading class="mt-4 text-xs text-gray-400">
        Syncing with server...
    </div>
</div>
