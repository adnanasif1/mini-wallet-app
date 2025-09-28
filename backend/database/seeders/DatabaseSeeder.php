<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use \App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(5)->create();

        $names = ['ali', 'omer', 'adnan', 'hamza', 'qayyim', 'subayyal'];
        foreach ($names as $name) {
            User::factory()->create([
                'name' => ucfirst($name),
                'email' => $name . '@example.com',
                'password' => Hash::make('secret123'),
                'email_verified_at' => now(),
                'balance' => fake()->numberBetween(0, 1000000),
                'remember_token' => Str::random(10),
            ]);
        }
    }
}
