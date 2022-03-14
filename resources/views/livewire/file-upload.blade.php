<div class="max-w-sm mx-auto bg-white rounded-xl shadow-lg p-6">
    <h2 class="text-lg font-bold text-gray-800 mb-4">File Upload — wire:model</h2>

    @if($saved)
        <div class="mb-4 p-3 bg-green-50 border border-green-200 rounded-lg text-green-700 text-sm">
            Avatar saved successfully!
        </div>
    @endif

    {{-- Preview of selected image --}}
    @if($photo)
        <div class="mb-4">
            <p class="text-xs text-gray-500 mb-2">Preview:</p>
            <img src="{{ $photo->temporaryUrl() }}" alt="Preview"
                 class="w-24 h-24 rounded-full object-cover border-4 border-indigo-200 mx-auto">
        </div>
    @endif

    <form wire:submit.prevent="save" class="space-y-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
            <input wire:model="name" type="text" placeholder="Contact name"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm
                          focus:outline-none focus:ring-2 focus:ring-indigo-400" />
            @error('name')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Photo</label>
            {{-- wire:model on file input triggers WithFileUploads --}}
            {{-- Livewire intercepts, uploads to /tmp, returns TemporaryUploadedFile --}}
            <input
                wire:model="photo"
                type="file"
                accept="image/*"
                class="w-full text-sm text-gray-500
                       file:mr-4 file:py-2 file:px-4
                       file:rounded-lg file:border-0
                       file:text-sm file:font-semibold
                       file:bg-indigo-50 file:text-indigo-700
                       hover:file:bg-indigo-100"
            />
            {{-- wire:loading shows a progress indicator during upload --}}
            <div wire:loading wire:target="photo" class="mt-2 text-xs text-indigo-600">
                Uploading...
            </div>
            @error('photo')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex gap-2">
            <button type="submit"
                class="flex-1 px-4 py-2 bg-indigo-600 text-white text-sm rounded-lg hover:bg-indigo-700">
                Save
            </button>
            @if($photo)
                <button type="button" wire:click="removePhoto"
                    class="px-4 py-2 border border-gray-300 text-gray-600 text-sm rounded-lg hover:bg-gray-50">
                    Remove
                </button>
            @endif
        </div>
    </form>

    <p class="mt-4 text-xs text-gray-400">
        Max size: 2MB. Accepted: JPEG, PNG, GIF, WebP
    </p>
</div>
