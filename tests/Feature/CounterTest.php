<?php

use App\Http\Livewire\Counter;
use Livewire\Livewire;

// Livewire testing with Pest: Livewire::test() wraps any component.
// Fluent API: call(), set(), assertSee(), assertSet().
// Way cleaner than React Testing Library + userEvent.

test('counter renders with initial count of zero', function () {
    Livewire::test(Counter::class)
        ->assertSee('0')
        ->assertSet('count', 0);
});

test('counter increments on button click', function () {
    Livewire::test(Counter::class)
        ->call('increment')
        ->assertSet('count', 1)
        ->call('increment')
        ->assertSet('count', 2);
});

test('counter decrements but does not go below zero', function () {
    Livewire::test(Counter::class)
        ->call('decrement')
        ->assertSet('count', 0)
        ->call('increment')
        ->call('increment')
        ->call('decrement')
        ->assertSet('count', 1);
});

test('counter resets to zero', function () {
    Livewire::test(Counter::class)
        ->call('increment')
        ->call('increment')
        ->call('increment')
        ->assertSet('count', 3)
        ->call('reset')
        ->assertSet('count', 0);
});
