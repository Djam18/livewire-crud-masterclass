<?php

namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    public function run(): void
    {
        $contacts = [
            ['name' => 'Taylor Otwell', 'email' => 'taylor@laravel.com', 'company' => 'Laravel', 'phone' => '+1-555-0101'],
            ['name' => 'Caleb Porzio', 'email' => 'caleb@alpinejs.dev', 'company' => 'Alpine.js / Livewire', 'phone' => '+1-555-0102'],
            ['name' => 'Adam Wathan', 'email' => 'adam@tailwindcss.com', 'company' => 'Tailwind CSS', 'phone' => '+1-555-0103'],
            ['name' => 'Jeffrey Way', 'email' => 'jeffrey@laracasts.com', 'company' => 'Laracasts', 'phone' => '+1-555-0104'],
            ['name' => 'Freek Van der Herten', 'email' => 'freek@spatie.be', 'company' => 'Spatie', 'phone' => '+32-555-0105'],
            ['name' => 'Marcel Pociot', 'email' => 'marcel@beyondco.de', 'company' => 'Beyond Code', 'phone' => '+49-555-0106'],
            ['name' => 'Nuno Maduro', 'email' => 'nuno@nunomaduro.com', 'company' => 'Laravel', 'phone' => '+1-555-0107'],
            ['name' => 'Jess Archer', 'email' => 'jess@inertiajs.com', 'company' => 'Inertia.js', 'phone' => '+61-555-0108'],
            ['name' => 'Ryan Chandler', 'email' => 'ryan@ryangjchandler.co.uk', 'company' => 'Independent', 'phone' => '+44-555-0109'],
            ['name' => 'Christoph Rumpel', 'email' => 'christoph@christoph-rumpel.com', 'company' => 'Independent', 'phone' => '+43-555-0110'],
        ];

        foreach ($contacts as $data) {
            Contact::firstOrCreate(['email' => $data['email']], $data);
        }
    }
}
