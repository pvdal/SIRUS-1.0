<?php

namespace Database\Seeders;

use App\Models\Coordinator;
use App\Models\Professor;
use App\Models\Student;
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

        Student::factory()->count(1000)->create();
        Professor::factory()->count(1000)->create();
        Coordinator::factory()->count(500)->create();
        $this->call(MemberTypesTableSeeder::class);

        $user = User::factory()->create([
            'name' => 'Administrador',
            'email' => 'root@root.com',
            'access_level' => 3,
            'state' => true,
            'email_verified_at' => now(),  // Adicionado para simular e-mail verificado
            'password' => Hash::make('123456789'),
        ]);

        Coordinator::create([
            'user_id' => $user->id,
        ]);
    }
}
