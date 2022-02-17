{{-- Modal controlled by $isOpen on the PHP component --}}
{{-- x-show bridges Alpine (CSS animation) with Livewire ($isOpen) --}}
<div>
    @if($isOpen)
    <div
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/40"
        x-data
        x-init="$el.querySelector('input').focus()"
        @keydown.escape.window="$wire.close()"
    >
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-md p-6" @click.stop>
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-bold text-gray-900">
                    {{ $contactId ? 'Edit Contact' : 'New Contact' }}
                </h2>
                <button wire:click="close" class="text-gray-400 hover:text-gray-600 text-2xl leading-none">&times;</button>
            </div>

            <form wire:submit.prevent="save" class="space-y-4">
                {{-- Name --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Name *</label>
                    <input
                        wire:model.lazy="name"
                        type="text"
                        class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2
                               {{ $errors->has('name') ? 'border-red-400 focus:ring-red-300' : 'border-gray-300 focus:ring-indigo-400' }}"
                        placeholder="Full name"
                    />
                    @error('name')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                    <input
                        wire:model.lazy="email"
                        type="email"
                        class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2
                               {{ $errors->has('email') ? 'border-red-400 focus:ring-red-300' : 'border-gray-300 focus:ring-indigo-400' }}"
                        placeholder="email@example.com"
                    />
                    @error('email')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Phone --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                    <input
                        wire:model.lazy="phone"
                        type="tel"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm
                               focus:outline-none focus:ring-2 focus:ring-indigo-400"
                        placeholder="+1 (555) 000-0000"
                    />
                </div>

                {{-- Company --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Company</label>
                    <input
                        wire:model.lazy="company"
                        type="text"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm
                               focus:outline-none focus:ring-2 focus:ring-indigo-400"
                        placeholder="Acme Corp"
                    />
                </div>

                {{-- Notes --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                    <textarea
                        wire:model.lazy="notes"
                        rows="3"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm
                               focus:outline-none focus:ring-2 focus:ring-indigo-400 resize-none"
                        placeholder="Any additional notes..."
                    ></textarea>
                </div>

                <div class="flex justify-end gap-3 pt-2">
                    <button
                        type="button"
                        wire:click="close"
                        class="px-4 py-2 text-sm text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-50"
                    >
                        Cancel
                    </button>
                    <button
                        type="submit"
                        class="px-4 py-2 text-sm text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 flex items-center gap-2"
                    >
                        <span wire:loading wire:target="save">
                            <svg class="animate-spin h-3 w-3" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.4 0 0 5.4 0 12h4z"></path>
                            </svg>
                        </span>
                        {{ $contactId ? 'Update' : 'Create' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>
