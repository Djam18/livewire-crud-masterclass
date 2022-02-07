<div class="max-w-lg mx-auto bg-white rounded-xl shadow-lg p-6">
    <h2 class="text-xl font-bold text-gray-800 mb-4">Live Search — wire:model</h2>

    {{-- wire:model binds the input value to $this->query in PHP --}}
    {{-- .debounce.300ms waits 300ms after typing stops before Ajax call --}}
    {{-- React equivalent: value={query} onChange={e => setQuery(e.target.value)} + useDebounce --}}
    <div class="relative mb-4">
        <input
            wire:model.debounce.300ms="query"
            type="search"
            placeholder="Search tools..."
            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg
                   focus:outline-none focus:ring-2 focus:ring-indigo-400"
        />
        <svg class="absolute left-3 top-2.5 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
        </svg>
        <div wire:loading wire:target="query" class="absolute right-3 top-2.5">
            <svg class="animate-spin h-4 w-4 text-indigo-500" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.4 0 0 5.4 0 12h4z"></path>
            </svg>
        </div>
    </div>

    {{-- wire:model also works with select, checkbox, radio --}}
    <select wire:model="selectedColor" class="w-full mb-4 border border-gray-300 rounded-lg px-3 py-2 text-sm">
        <option value="">All colors</option>
        <option value="blue">Blue</option>
        <option value="pink">Pink</option>
        <option value="red">Red</option>
        <option value="cyan">Cyan</option>
        <option value="green">Green</option>
        <option value="purple">Purple</option>
        <option value="yellow">Yellow</option>
    </select>

    <p class="text-xs text-gray-500 mb-3">
        {{ count($this->results) }} result(s) for "{{ $query }}"
    </p>

    <ul class="space-y-2">
        @forelse($this->results as $item)
            <li class="flex items-center gap-3 p-3 rounded-lg border border-gray-100 hover:bg-gray-50">
                <span class="w-2 h-2 rounded-full bg-{{ $item['color'] }}-400"></span>
                <div>
                    <span class="font-medium text-gray-800">{{ $item['name'] }}</span>
                    <span class="text-xs text-gray-500 ml-2">{{ $item['category'] }}</span>
                </div>
            </li>
        @empty
            <li class="text-center text-gray-400 py-6 text-sm">No results found</li>
        @endforelse
    </ul>
</div>
