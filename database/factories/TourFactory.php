<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tour>
 */
class TourFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = 'تور' . " " . fake()->words(2, true);
        return [
            'title' => $title,
            'slug' => str_ireplace(' ', '-', $title),
            'active' => true,
        ];
    }
}
