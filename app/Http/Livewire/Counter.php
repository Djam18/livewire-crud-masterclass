<?php

namespace App\Http\Livewire;

use Livewire\Component;

// Premier composant Livewire. C'est... du PHP qui réagit?
// En React j'aurais écrit un useState + fetch + useEffect.
// Là: une classe PHP avec une propriété publique. C'est tout.
// Quand on clique "wire:click='increment'", Livewire fait un
// POST Ajax, appelle increment() côté serveur, re-rend le Blade.
// Le state vit sur le SERVEUR. Pas dans le browser. Ma tête.

class Counter extends Component
{
    public int $count = 0;

    public function increment(): void
    {
        $this->count++;
    }

    public function decrement(): void
    {
        $this->count = max(0, $this->count - 1);
    }

    public function reset(): void
    {
        $this->count = 0;
    }

    public function render()
    {
        return view('livewire.counter');
    }
}
