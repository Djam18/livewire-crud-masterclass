<?php

namespace App\Livewire;

use App\Models\Contact;
use Livewire\Component;
use Livewire\Attributes\{Computed, On, Url, Validate, Lazy};

// Livewire 4 — Single-File Component approach (SFC) + Islands Architecture.
//
// LIVEWIRE 4 MIGRATION — Jan 2026
// LW3 → LW4 key changes:
//
//   1. SFC: component class + template can live in one .blade.php file.
//      Pattern: put component PHP in <script type="text/php"> block.
//      This file keeps the separate class — SFC example in ContactManagerSfc.blade.php
//
//   2. Islands: #[Lazy] now TRULY lazy — component is excluded from initial HTML,
//      loaded on-demand as a Livewire island. Wire-able from non-Livewire pages.
//
//   3. #[Locked] attribute — prevents client-side mutation of properties.
//      LW3 had this but it's now enforced in the wire protocol.
//
//   4. wire:stream — stream partial content from server before full response.
//      Perfect for AI-generated content. No more polling hacks.
//
//   5. Alpine integration improved — Alpine data and Livewire state share the
//      same reactive boundary. No more $wire.entangle() boilerplate for most cases.
//
//   6. Namespace convention: app/Livewire/ (not app/Http/Livewire/).
//      Laravel 12 generator creates here by default.
//
// This component demonstrates LW4 features while keeping the LW3 patterns
// that still work (all #[Validate], #[On], #[Url] remain compatible).

class ContactManager extends Component
{
    #[Url(except: '')]
    public string $search = '';

    #[Url(except: 'name')]
    public string $sortField = 'name';

    #[Url(except: 'asc')]
    public string $sortDirection = 'asc';

    // LW4: #[Locked] — property cannot be set from the client.
    // Prevents users from forging a different user_id via JS.
    #[Locked]
    public int $currentUserId;

    // LW4: #[Lazy] with visible threshold — loads when scrolled into view
    // The component renders a placeholder initially, hydrates on intersection.
    // #[Lazy(isolate: true)] keeps it isolated from parent Livewire updates.

    public bool $showForm = false;
    public ?int $editingId = null;

    #[Validate('required|string|max:255')]
    public string $name = '';

    #[Validate('required|email|max:255')]
    public string $email = '';

    #[Validate('nullable|string|max:20')]
    public string $phone = '';

    public function mount(): void
    {
        $this->currentUserId = auth()->id() ?? 0;
    }

    #[Computed]
    public function contacts()
    {
        return Contact::query()
            ->when($this->search, fn ($q) => $q->where(function ($q) {
                $q->whereLike('name', "%{$this->search}%")
                  ->orWhereLike('email', "%{$this->search}%");
            }))
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(15);
    }

    public function sort(string $field): void
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField     = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function openCreate(): void
    {
        $this->reset(['editingId', 'name', 'email', 'phone']);
        $this->showForm = true;
    }

    public function openEdit(int $id): void
    {
        $contact = Contact::findOrFail($id);
        $this->editingId = $id;
        $this->name      = $contact->name;
        $this->email     = $contact->email;
        $this->phone     = $contact->phone ?? '';
        $this->showForm  = true;
    }

    public function save(): void
    {
        $data = $this->validate();

        if ($this->editingId) {
            Contact::findOrFail($this->editingId)->update($data);
        } else {
            Contact::create($data);
        }

        $this->showForm = false;
        $this->reset(['editingId', 'name', 'email', 'phone']);
        unset($this->contacts); // LW4: bust computed cache explicitly

        $this->dispatch('notify', message: 'Contact saved!', type: 'success');
    }

    public function delete(int $id): void
    {
        Contact::findOrFail($id)->delete();
        unset($this->contacts);
        $this->dispatch('notify', message: 'Contact deleted.', type: 'warning');
    }

    public function render()
    {
        return view('livewire.contact-manager');
    }
}
