<?php

namespace App\Http\Livewire;

use App\Models\Contact;
use Livewire\Component;

// Alpine handles the modal animation (CSS transitions).
// Livewire handles the actual delete (PHP logic).
// This is the "best of both worlds" pattern:
// Alpine for UI state (open/close), Livewire for server actions.
// The bridge: $wire.set('isOpen', false) from Alpine to Livewire.

class DeleteConfirmation extends Component
{
    public bool $isOpen = false;
    public ?int $contactId = null;
    public string $contactName = '';

    protected $listeners = [
        'confirmDelete' => 'openConfirm',
    ];

    public function openConfirm(int $id): void
    {
        $contact = Contact::findOrFail($id);
        $this->contactId = $contact->id;
        $this->contactName = $contact->name;
        $this->isOpen = true;
    }

    public function delete(): void
    {
        if ($this->contactId) {
            Contact::findOrFail($this->contactId)->delete();
            session()->flash('status', "{$this->contactName} deleted.");
            $this->emit('contactSaved');
        }

        $this->close();
    }

    public function close(): void
    {
        $this->isOpen = false;
        $this->contactId = null;
        $this->contactName = '';
    }

    public function render()
    {
        return view('livewire.delete-confirmation');
    }
}
