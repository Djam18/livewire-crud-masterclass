# Livewire CRUD Masterclass

Learning Livewire 2.8 after 5 years of React. This repo documents the journey.

Laravel 9 + Livewire 2.8 | PHP 8.1 | Pest | 2022

---

## The Mental Shift

Coming from React, Livewire required rewiring how I think about state.

| Concept | React | Livewire |
|---------|-------|----------|
| State | `useState()` in browser | PHP class properties on server |
| Data binding | `value + onChange` | `wire:model` |
| Event handling | `onClick={handler}` | `wire:click="method"` |
| Validation | react-hook-form + yup | `$rules` array + `validate()` |
| Lists | `.map()` with keys | `@forelse` with `wire:key` |
| Loading states | `useState(false)` | `wire:loading` directive |
| File uploads | FileReader + FormData | `WithFileUploads` trait |
| Pagination | Manual with react-query | `WithPagination` trait |
| Real-time search | debounce + useEffect | `wire:model.debounce.300ms` |
| Testing | RTL + userEvent | `Livewire::test()->call()` |

## What I Built

| Component | Feature | Key Learnings |
|-----------|---------|---------------|
| `Counter` | First `wire:click` | PHP state, Ajax round-trip |
| `LiveSearch` | `wire:model.debounce` | Computed properties |
| `ContactTable` | Search + sort + paginate | `WithPagination`, `updatingSearch()` |
| `ContactForm` | CRUD + validation | `$rules`, `validate()`, Livewire events |
| `DeleteConfirmation` | Alpine + Livewire bridge | `$wire.property` from Alpine |
| `FileUpload` | `WithFileUploads` | `temporaryUrl()`, temp storage |
| `BulkActions` | Select all + bulk delete | Array properties, `updatedSelectAll()` |
| `FlashMessage` | Global event listener | `$listeners`, Livewire events |

## Key Discoveries

### 1. The state lives on the server

Every `wire:click` is an Ajax POST. PHP runs the method. Blade re-renders.
Livewire diffs the DOM and patches it. No client-side state management.

In React I manage 50 `useState` calls, coordinate them with `useEffect`, worry
about stale closures... In Livewire: `$this->count++`. That's it.

### 2. `wire:model` is magic

React: `<input value={name} onChange={e => setName(e.target.value)} />`

Livewire: `<input wire:model="name" />`

The `$name` property updates automatically. Debouncing: `wire:model.debounce.300ms`.

### 3. Alpine + Livewire = perfect complementarity

- **Alpine**: UI state (open/close, animation) — client-side only
- **Livewire**: Business logic (CRUD, validation, data) — server-side

### 4. Testing is first-class

```php
Livewire::test(ContactForm::class)
    ->call('openCreate')
    ->set('email', 'not-valid')
    ->call('save')
    ->assertHasErrors(['email' => 'email']);
```

## First impression

```
// React: useState + useEffect + fetch + loading + error + optimistic...
const [contacts, setContacts] = useState([]);
const [loading, setLoading] = useState(true);
useEffect(() => { fetch('/api/contacts').then(r => r.json()).then(setContacts) }, []);

// Livewire:
class ContactTable extends Component {
    public function render() {
        return view('livewire.contact-table', [
            'contacts' => Contact::all()
        ]);
    }
}
```

The state is on the SERVER. PHP manages state. Blade renders it.
Every interaction makes a request, diffs, and patches the DOM.
Like React Server Components but from 2019.

## Verdict

For CRUD apps, dashboards, admin panels — Livewire doesn't just compete with React.
It wins. Less code. Less complexity. No client-server data sync issues.
The cognitive overhead is a fraction of what I was carrying with React + API + state.
