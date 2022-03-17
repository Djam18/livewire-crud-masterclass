<div class="bg-white rounded-xl shadow">
    {{-- Bulk action toolbar — shows when items selected --}}
    @if(count($selected) > 0)
        <div class="px-6 py-3 bg-indigo-50 border-b border-indigo-200 flex items-center justify-between">
            <span class="text-sm font-medium text-indigo-700">
                {{ count($selected) }} contact(s) selected
            </span>
            <div class="flex gap-2">
                <button
                    wire:click="deleteSelected"
                    wire:confirm="Delete {{ count($selected) }} contact(s)? This cannot be undone."
                    class="px-3 py-1.5 bg-red-600 text-white text-xs rounded hover:bg-red-700"
                >
                    Delete Selected
                </button>
                <button wire:click="$set('selected', [])" class="px-3 py-1.5 border border-gray-300 text-gray-600 text-xs rounded">
                    Deselect All
                </button>
            </div>
        </div>
    @endif

    {{-- Search --}}
    <div class="px-6 py-4 border-b border-gray-200">
        <input
            wire:model.debounce.300ms="search"
            type="search"
            placeholder="Search contacts..."
            class="w-full max-w-xs border border-gray-300 rounded-lg px-3 py-2 text-sm
                   focus:outline-none focus:ring-2 focus:ring-indigo-400"
        />
    </div>

    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
            <tr>
                <th class="px-6 py-3 text-left w-10">
                    {{-- wire:model on checkbox syncs with $selectAll --}}
                    {{-- updatedSelectAll() fires on change --}}
                    <input type="checkbox" wire:model="selectAll" class="rounded border-gray-300" />
                </th>
                <th class="px-6 py-3 text-left">Name</th>
                <th class="px-6 py-3 text-left">Email</th>
                <th class="px-6 py-3 text-left">Company</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($contacts as $contact)
                <tr wire:key="bulk-{{ $contact->id }}"
                    :class="$wire.selected.includes('{{ $contact->id }}') ? 'bg-indigo-50' : ''"
                    class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-3">
                        {{-- Each checkbox pushes/removes from $selected array --}}
                        <input
                            type="checkbox"
                            wire:model="selected"
                            value="{{ $contact->id }}"
                            class="rounded border-gray-300"
                        />
                    </td>
                    <td class="px-6 py-3 font-medium text-gray-900">{{ $contact->name }}</td>
                    <td class="px-6 py-3 text-gray-600">{{ $contact->email }}</td>
                    <td class="px-6 py-3 text-gray-600">{{ $contact->company ?? '—' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="px-6 py-12 text-center text-gray-400">No contacts found</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @if($contacts->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $contacts->links() }}
        </div>
    @endif
</div>
