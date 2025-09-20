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
<<<<<<< HEAD
        Student::factory()->count(10)->create();
        Professor::factory()->count(10)->create();
=======
        Student::factory()->count(100)->create();
        Professor::factory()->count(100)->create();
>>>>>>> 1ebe5cc81cc5e0e661156ed62e7690b54d708019
        Coordinator::factory()->count(50)->create();
        $this->call(MemberTypesTableSeeder::class);

        $user = User::factory()->create([
            'name' => 'Pedro Lima',
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
