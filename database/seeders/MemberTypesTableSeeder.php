<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MemberTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            'Presidente',
            'Coordenador',
            'Convidado',
            'Orientador',
            'Especialista',
            'Membro'
        ];

        foreach ($types as $type) {
            DB::table('member_types')->insert([
                'name' => $type,
                'state' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
