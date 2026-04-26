<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ProductionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call(MemberTypesTableSeeder::class);

        User::create([
            'name' => 'Administrador',
            'email' => 'root@root.com',
            'access_level' => 3,
            'state' => true,
            'email_verified_at' => now(),  // Adicionado para simular e-mail verificado
            'password' => Hash::make(config('auth.admin_password')),
        ]);
    }
}
