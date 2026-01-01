<?php

// Livewire 4 — Single-File Component (SFC).
//
// The PHP class lives right here in the Blade file.
// No separate app/Livewire/Counter.php needed.
//
// React comparison:
//   React: JSX + JS logic in one .jsx file (always been SFC)
//   Vue:   <template> + <script> + <style> in one .vue file (SFC since Vue 2)
//   LW4:   PHP class + Blade template in one .blade.php file
//
// Trade-offs:
//   Pro: co-location, faster iteration, less file-switching
//   Con: larger files, harder to unit-test the class in isolation
//         (have to use Livewire test helpers even for pure logic)
//
// Best for: small, focused components (counters, toggles, simple forms)
// Keep separate class for: complex components with injected services

use Livewire\Attributes\{Validate, Computed};
use Livewire\Component;

new class extends Component {
    public int $count = 0;
    public int $step  = 1;

    #[Validate('required|integer|min:1|max:100')]
    public int $customStep = 1;

    public function increment(): void
    {
        $this->count += $this->step;
    }

    public function decrement(): void
    {
        $this->count = max(0, $this->count - $this->step);
    }

    public function reset(): void
    {
        $this->count = 0;
    }

    #[Computed]
    public function isEven(): bool
    {
        return $this->count % 2 === 0;
    }
}

?>

{{-- Template follows immediately after the PHP class --}}
<div class="p-6 bg-white rounded-xl border border-gray-200 shadow-sm max-w-sm">
    <h2 class="text-lg font-semibold text-gray-900 mb-4">Counter (SFC)</h2>

    <div class="flex items-center justify-center gap-4 my-6">
        <button
            wire:click="decrement"
            class="h-10 w-10 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-700 text-xl font-bold"
        >
            −
        </button>

        <span class="text-4xl font-bold tabular-nums @if($this->isEven) text-indigo-600 @else text-gray-900 @endif">
            {{ $count }}
        </span>

        <button
            wire:click="increment"
            class="h-10 w-10 rounded-full bg-indigo-600 hover:bg-indigo-700 text-white text-xl font-bold"
        >
            +
        </button>
    </div>

    <div class="flex items-center gap-2 text-sm">
        <label class="text-gray-600">Step:</label>
        <input wire:model.live="step" type="number" min="1" max="100"
               class="w-20 border rounded px-2 py-1 text-sm text-center">
    </div>

    <button wire:click="reset" class="mt-4 text-sm text-gray-400 hover:text-gray-600 underline">
        Reset
    </button>

    <p class="mt-2 text-xs text-gray-400">
        {{ $this->isEven ? 'Even number' : 'Odd number' }}
        — LW4 SFC example
    </p>
</div>
