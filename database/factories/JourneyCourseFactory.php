<?php

namespace Database\Factories;

use App\Enums\TransportationType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JourneyCourse>
 */
class JourneyCourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'transportation_type' => TransportationType::AIRPLANE,
            'departure_time' => fake()->time('H:i'),
            'duration' => '0' . fake()->numberBetween(1, 4) . ':00',
            'transition_time' => '01:00',
            'item_number' => fake()->numberBetween(1000, 9999),
            'baggage' => fake()->numberBetween(3, 5) * 10
        ];
    }
}
