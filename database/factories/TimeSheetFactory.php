<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TimeSheet>
 */
class TimeSheetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'project_id' => \App\Models\Project::factory(),
            'user_id' => \App\Models\User::factory(),
            'task_name' => fake()->words(3, true),
            'date' => fake()->date(),
            'hours' => fake()->randomFloat(2, 0, 8),
        ];
    }
}
