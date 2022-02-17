<?php

namespace App\Http\Livewire;

use App\Models\Contact;
use Livewire\Component;

// Validation in Livewire: just a $rules array. No FormRequest needed
// for simple forms (though you can use them).
// validate() runs $rules, populates $errors bag, re-renders.
// Real-time validation: wire:model.lazy + validate() per field.
// In React: react-hook-form + yup/zod + error states. All manual.
// Here: $rules + validate() + @error in Blade. That's the whole stack.

class ContactForm extends Component
{
    public ?int $contactId = null;
    public string $name = '';
    public string $email = '';
    public string $phone = '';
    public string $company = '';
    public string $notes = '';
    public bool $isOpen = false;

    protected array $rules = [
        'name'    => ['required', 'string', 'max:255'],
        'email'   => ['required', 'email', 'max:255'],
        'phone'   => ['nullable', 'string', 'max:20'],
        'company' => ['nullable', 'string', 'max:255'],
        'notes'   => ['nullable', 'string', 'max:1000'],
    ];

    protected $listeners = [
        'openCreateModal' => 'openCreate',
        'openEditModal'   => 'openEdit',
    ];

    public function openCreate(): void
    {
        $this->reset(['contactId', 'name', 'email', 'phone', 'company', 'notes']);
        $this->isOpen = true;
    }

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
            session()->flash('status', 'Contact updated.');
        } else {
            Contact::create($validated);
            session()->flash('status', 'Contact created.');
        }

        $this->isOpen = false;
        $this->emit('contactSaved');
    }

    public function close(): void
    {
        $this->isOpen = false;
        $this->resetErrorBag();
    }

    // Real-time validation per field (called when wire:model.lazy updates)
    public function updated(string $field): void
    {
        $this->validateOnly($field);
    }

    public function render()
    {
        return view('livewire.contact-form');
    }
}
