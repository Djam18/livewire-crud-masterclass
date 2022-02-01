# Livewire CRUD Masterclass

Learning Livewire 2.x — from a React/Django developer.

Laravel 9 + Livewire 2.8 | PHP 8.1 | Pest | February 2022

---

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
