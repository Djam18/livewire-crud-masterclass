<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

// File uploads in Livewire: WithFileUploads trait.
// wire:model on a file input -> Livewire intercepts the upload,
// sends it to a temp directory, gives back a TemporaryUploadedFile.
// Preview before save: $photo->temporaryUrl() returns a signed URL.
// In React: FileReader API + useState + FormData + fetch. Manual.
// Here: one trait + wire:model. Done.

class FileUpload extends Component
{
    use WithFileUploads;

    public $photo = null;
    public string $name = '';
    public bool $saved = false;

    protected array $rules = [
        'photo' => ['nullable', 'image', 'max:2048'],
        'name'  => ['required', 'string', 'max:255'],
    ];

    public function updatedPhoto(): void
    {
        $this->validateOnly('photo');
        $this->saved = false;
    }

    public function save(): void
    {
        $this->validate();

        // In a real app: $path = $this->photo->store('avatars', 'public');
        // Contact::findOrFail($this->contactId)->update(['avatar' => $path]);

        $this->saved = true;
        $this->photo = null;
    }

    public function removePhoto(): void
    {
        $this->photo = null;
        $this->saved = false;
    }

    public function render()
    {
        return view('livewire.file-upload');
    }
}
