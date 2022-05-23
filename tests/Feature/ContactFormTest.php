<?php

use App\Http\Livewire\ContactForm;
use App\Models\Contact;
use Livewire\Livewire;

// Livewire testing is the best I've seen for full-stack component testing.
// No mocking needed for validation — it runs real validation rules.
// assertHasErrors() + assertSee() covers most form test cases.

test('contact form validates required fields', function () {
    Livewire::test(ContactForm::class)
        ->call('openCreate')
        ->call('save')
        ->assertHasErrors(['name' => 'required', 'email' => 'required']);
});

test('contact form validates email format', function () {
    Livewire::test(ContactForm::class)
        ->call('openCreate')
        ->set('name', 'John Doe')
        ->set('email', 'not-an-email')
        ->call('save')
        ->assertHasErrors(['email' => 'email']);
});

test('contact form creates a contact successfully', function () {
    Livewire::test(ContactForm::class)
        ->call('openCreate')
        ->set('name', 'Jane Smith')
        ->set('email', 'jane@example.com')
        ->set('phone', '+1-555-0100')
        ->set('company', 'Acme Corp')
        ->call('save')
        ->assertSet('isOpen', false)
        ->assertHasNoErrors();

    $this->assertDatabaseHas('contacts', [
        'email' => 'jane@example.com',
        'name'  => 'Jane Smith',
    ]);
});

test('contact form loads existing contact for editing', function () {
    $contact = Contact::factory()->create([
        'name'  => 'Edit Me',
        'email' => 'edit@example.com',
    ]);

    Livewire::test(ContactForm::class)
        ->call('openEdit', $contact->id)
        ->assertSet('name', 'Edit Me')
        ->assertSet('email', 'edit@example.com')
        ->assertSet('isOpen', true);
});

test('contact form closes on cancel', function () {
    Livewire::test(ContactForm::class)
        ->call('openCreate')
        ->assertSet('isOpen', true)
        ->call('close')
        ->assertSet('isOpen', false);
});
