<?php

namespace Database\Factories;

use App\Models\Committee;
use App\Models\Coordinator;
use App\Models\Paper;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class CommitteeFactory extends Factory
{
    protected $model = Committee::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'rubric_id' => $this->faker->randomNumber(),
            'start' => Carbon::now(),
            'end' => Carbon::now(),
            'state' => $this->faker->boolean(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'coordinator_id' => Coordinator::factory(),
            'paper_id' => Paper::factory(),
        ];
    }
}
