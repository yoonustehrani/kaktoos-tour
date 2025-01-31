<?php

namespace Database\Factories;

use App\Models\Country;
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
        return [
            'active' => true,
        ];
    }

    public function country(string $code)
    {
        $title = 'تور' . " " . Country::whereCode($code)->first()->name_fa;
        return $this->state([
            'title' => $title,
            'slug' => str_ireplace(' ', '-', $title)
        ]);
    }
}
