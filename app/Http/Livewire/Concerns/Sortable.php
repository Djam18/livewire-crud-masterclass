<?php

namespace App\Http\Livewire\Concerns;

// Livewire trait for reusable sortable column logic.
// Extracted so any table component can use it.
// In React: a custom hook useSort(). Same pattern, different world.

trait Sortable
{
    public string $sortField = 'created_at';
    public string $sortDirection = 'desc';

    public function sortBy(string $field): void
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }

        // Reset to first page on sort change (requires WithPagination)
        if (method_exists($this, 'resetPage')) {
            $this->resetPage();
        }
    }

    public function getSortIcon(string $field): string
    {
        if ($this->sortField !== $field) {
            return '↕';
        }

        return $this->sortDirection === 'asc' ? '↑' : '↓';
    }
}
