<?php

namespace App\Http\Livewire;

use App\Models\Contact;
use Livewire\Component;
use Livewire\WithPagination;

class BulkActions extends Component
{
    use WithPagination;

    public array $selected = [];
    public bool $selectAll = false;
    public string $search = '';

    public function updatedSelectAll(bool $value): void
    {
        if ($value) {
            $this->selected = $this->getContacts()
                ->pluck('id')
                ->map(fn($id) => (string) $id)
                ->toArray();
        } else {
            $this->selected = [];
        }
    }

    public function updatedSelected(): void
    {
        $this->selectAll = count($this->selected) === $this->getContacts()->count();
    }

    public function deleteSelected(): void
    {
        if (empty($this->selected)) {
            return;
        }

        Contact::whereIn('id', $this->selected)->delete();
        $this->selected = [];
        $this->selectAll = false;
        session()->flash('status', 'Selected contacts deleted.');
    }

    private function getContacts()
    {
        return Contact::query()
            ->when($this->search, fn($q) => $q->search($this->search))
            ->get();
    }

    public function render()
    {
        $contacts = Contact::query()
            ->when($this->search, fn($q) => $q->search($this->search))
            ->paginate(10);

        return view('livewire.bulk-actions', compact('contacts'));
    }
}
