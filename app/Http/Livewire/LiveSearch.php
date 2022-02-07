<?php

namespace App\Http\Livewire;

use Livewire\Component;

// wire:model is... React controlled inputs but server-side.
// Every keystroke -> Ajax -> PHP updates $query -> re-renders.
// wire:model.debounce.300ms avoids flooding the server.
// In React: value={query} onChange={e => setQuery(e.target.value)}
// In Livewire: wire:model.debounce.300ms="query"
// The Blade template just reads $this->query. That's it.

class LiveSearch extends Component
{
    public string $query = '';
    public string $selectedColor = '';

    // Computed property — runs when $query changes
    public function getResultsProperty(): array
    {
        $items = [
            ['name' => 'Alpine.js', 'category' => 'Frontend', 'color' => 'blue'],
            ['name' => 'Livewire', 'category' => 'Full-stack', 'color' => 'pink'],
            ['name' => 'Laravel', 'category' => 'Backend', 'color' => 'red'],
            ['name' => 'Tailwind CSS', 'category' => 'Styling', 'color' => 'cyan'],
            ['name' => 'Pest PHP', 'category' => 'Testing', 'color' => 'green'],
            ['name' => 'Inertia.js', 'category' => 'Bridge', 'color' => 'purple'],
            ['name' => 'Vite', 'category' => 'Build tool', 'color' => 'yellow'],
        ];

        return collect($items)
            ->filter(fn($item) =>
                str_contains(strtolower($item['name']), strtolower($this->query)) ||
                str_contains(strtolower($item['category']), strtolower($this->query))
            )
            ->when($this->selectedColor, fn($c) =>
                $c->filter(fn($item) => $item['color'] === $this->selectedColor)
            )
            ->values()
            ->toArray();
    }

    public function render()
    {
        return view('livewire.live-search');
    }
}
