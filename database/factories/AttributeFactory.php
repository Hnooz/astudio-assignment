<?php

namespace Database\Factories;

use App\Enums\AttributeTypeEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Attribute>
 */
class AttributeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->randomElement(['department', 'start_date', 'end_date']),
            'type' => fake()->randomElement(AttributeTypeEnum::cases()),
        ];
    }
}
