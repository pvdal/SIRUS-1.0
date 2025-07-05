<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call(EventsTableSeeder::class);

        User::factory()->create([
            'name' => 'Pedro Lima',
            'email' => 'root@root.com',
            'email_verified_at' => now(),  // Adicionado para simular e-mail verificado
            'password' => Hash::make('123456789'),
        ]);
    }
}
