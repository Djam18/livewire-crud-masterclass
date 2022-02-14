<div class="bg-white rounded-xl shadow">
    {{-- Search bar — wire:model.debounce.300ms for real-time search --}}
    <div class="px-6 py-4 border-b border-gray-200 flex items-center gap-4">
        <div class="relative flex-1">
            <input
                wire:model.debounce.300ms="search"
                type="search"
                placeholder="Search contacts..."
                class="w-full pl-9 pr-4 py-2 border border-gray-300 rounded-lg text-sm
                       focus:outline-none focus:ring-2 focus:ring-indigo-400"
            />
            <svg class="absolute left-3 top-2.5 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
        </div>

        <select wire:model="perPage" class="border border-gray-300 rounded-lg px-3 py-2 text-sm">
            <option value="5">5 / page</option>
            <option value="10">10 / page</option>
            <option value="25">25 / page</option>
        </select>

        <button
            wire:click="$emit('openCreateModal')"
            class="px-4 py-2 bg-indigo-600 text-white text-sm rounded-lg hover:bg-indigo-700"
        >
            + Add Contact
        </button>
    </div>

    {{-- Table --}}
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-6 py-3 text-left">
                        <button wire:click="sortBy('name')" class="flex items-center gap-1 hover:text-gray-900">
                            Name
                            @if($sortField === 'name')
                                <span>{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                            @endif
                        </button>
                    </th>
                    <th class="px-6 py-3 text-left">
                        <button wire:click="sortBy('email')" class="flex items-center gap-1 hover:text-gray-900">
                            Email
                            @if($sortField === 'email')
                                <span>{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                            @endif
                        </button>
                    </th>
                    <th class="px-6 py-3 text-left">
                        <button wire:click="sortBy('company')" class="flex items-center gap-1 hover:text-gray-900">
                            Company
                            @if($sortField === 'company')
                                <span>{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                            @endif
                        </button>
                    </th>
                    <th class="px-6 py-3 text-left">Phone</th>
                    <th class="px-6 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($contacts as $contact)
                    <tr class="hover:bg-gray-50 transition-colors" wire:key="contact-{{ $contact->id }}">
                        <td class="px-6 py-4 font-medium text-gray-900">
                            {{ $contact->name }}
                        </td>
                        <td class="px-6 py-4 text-gray-600">
                            {{ $contact->email }}
                        </td>
                        <td class="px-6 py-4 text-gray-600">
                            {{ $contact->company ?? '—' }}
                        </td>
                        <td class="px-6 py-4 text-gray-600">
                            {{ $contact->phone ?? '—' }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <button
                                wire:click="$emit('openEditModal', {{ $contact->id }})"
                                class="text-indigo-600 hover:text-indigo-800 mr-3 text-xs font-medium"
                            >Edit</button>
                            <button
                                wire:click="$emit('confirmDelete', {{ $contact->id }})"
                                class="text-red-500 hover:text-red-700 text-xs font-medium"
                            >Delete</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-400">
                            @if($search)
                                No contacts found for "{{ $search }}"
                            @else
                                No contacts yet. Add one above.
                            @endif
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination — WithPagination trait handles this automatically --}}
    @if($contacts->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $contacts->links() }}
        </div>
    @endif

    {{-- Wire loading overlay --}}
    <div wire:loading.delay class="absolute inset-0 bg-white/50 flex items-center justify-center">
        <svg class="animate-spin h-6 w-6 text-indigo-500" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.4 0 0 5.4 0 12h4z"></path>
        </svg>
    </div>
</div>
