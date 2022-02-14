<?php

namespace App\Http\Livewire;

use App\Models\Contact;
use Livewire\Component;
use Livewire\WithPagination;

// ContactTable: the moment Livewire clicked for me.
// Real-time search + pagination with NO JavaScript written.
// In React: useState, useEffect, fetch, loading state, pagination state...
// Here: wire:model="search" -> $search updates -> computed query re-runs -> Blade re-renders.
// WithPagination handles the pagination links. Automatically.
// I keep waiting for the catch. There isn't one.

class ContactTable extends Component
{
    use WithPagination;

    public string $search = '';
    public string $sortField = 'name';
    public string $sortDirection = 'asc';
    public int $perPage = 10;

    // Reset to page 1 whenever search changes
    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function sortBy(string $field): void
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function render()
    {
        $contacts = Contact::query()
            ->when($this->search, fn($q) => $q->search($this->search))
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.contact-table', compact('contacts'));
    }
}
