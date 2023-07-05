<?php

namespace App\Http\Livewire;

use App\Models\Contact;
use Livewire\Component;
use Livewire\Attributes\Validate;
use Livewire\Attributes\On;

// LIVEWIRE 3 MIGRATION — Jul 2023
// LW2 → LW3 breaking changes applied here:
//   protected $rules  → #[Validate] per property
//   protected $listeners → #[On('event')] per method
//   $this->emit()     → $this->dispatch()
//   wire:model.lazy   → wire:model.blur (in blade)
//   wire:model.defer  → wire:model (deferred by default now)
// New in LW3 used here:
//   #[Validate] attribute — validation co-located with property
//   #[On] attribute — listener declared at method level

class ContactForm extends Component
{
    public ?int $contactId = null;

    #[Validate('required|string|max:255')]
    public string $name = '';

    #[Validate('required|email|max:255')]
    public string $email = '';

    #[Validate('nullable|string|max:20')]
    public string $phone = '';

    #[Validate('nullable|string|max:255')]
    public string $company = '';

    #[Validate('nullable|string|max:1000')]
    public string $notes = '';

    public bool $isOpen = false;

    // LW3: #[On] replaces protected $listeners array
    #[On('openCreateModal')]
    public function openCreate(): void
    {
        $this->reset(['contactId', 'name', 'email', 'phone', 'company', 'notes']);
        $this->isOpen = true;
    }

    #[On('openEditModal')]
    public function openEdit(int $id): void
    {
        $contact = Contact::findOrFail($id);
        $this->contactId = $contact->id;
        $this->name = $contact->name;
        $this->email = $contact->email;
        $this->phone = $contact->phone ?? '';
        $this->company = $contact->company ?? '';
        $this->notes = $contact->notes ?? '';
        $this->isOpen = true;
    }

    public function save(): void
    {
        $validated = $this->validate();

        if ($this->contactId) {
            Contact::findOrFail($this->contactId)->update($validated);
        } else {
            Contact::create($validated);
        }

        $this->isOpen = false;
        // LW3: $this->emit() → $this->dispatch()
        $this->dispatch('contactSaved');
        $this->dispatch('notify', message: 'Contact saved!', type: 'success');
    }

    public function close(): void
    {
        $this->isOpen = false;
        $this->resetErrorBag();
    }

    public function updated(string $field): void
    {
        $this->validateOnly($field);
    }

    public function render()
    {
        return view('livewire.contact-form');
    }
}
