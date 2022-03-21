<?php

namespace App\Http\Livewire;

use Livewire\Component;

// Flash messages in Livewire: session()->flash() + $this->emit('flash', ...).
// Pattern 1: session()->flash('status', 'Done') — persists in session for one request.
// Pattern 2: $this->dispatchBrowserEvent('notify', ['message' => 'Done']) — JS toast.
// Here: a global FlashMessage component that listens for 'flash' events.
// Any Livewire component can emit('flash', ...) and this component shows it.

class FlashMessage extends Component
{
    public ?string $message = null;
    public string $type = 'success';
    public bool $visible = false;

    protected $listeners = [
        'flash' => 'show',
    ];

    public function show(string $message, string $type = 'success'): void
    {
        $this->message = $message;
        $this->type = $type;
        $this->visible = true;
    }

    public function dismiss(): void
    {
        $this->visible = false;
        $this->message = null;
    }

    public function render()
    {
        return view('livewire.flash-message');
    }
}
