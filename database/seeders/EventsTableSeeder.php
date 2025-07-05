<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EventsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('events')->insert([
            [
                'title' => 'Reunião de Projeto',
                'start' => Carbon::create(2025, 7, 10, 14, 0, 0),
                'end' => Carbon::create(2025, 7, 10, 15, 0, 0),
                'color' => '#ff0000',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Treinamento Laravel',
                'start' => Carbon::create(2025, 7, 12, 9, 0, 0),
                'end' => Carbon::create(2025, 7, 12, 12, 0, 0),
                'color' => '#00ff00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Apresentação Final',
                'start' => Carbon::create(2025, 7, 15, 10, 0, 0),
                'end' => Carbon::create(2025, 7, 15, 11, 30, 0),
                'color' => '#0000ff',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
