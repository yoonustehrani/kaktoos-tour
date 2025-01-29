<?php

namespace Database\Factories;

use DateInterval;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TourDate>
 */
class TourDateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [];
    }

    public function days(int $days)
    {
        return $this->state(fn (array $attributes) => [
            'end_date' => Carbon::createFromFormat('Y-m-d', $attributes['start_date'])->addDays($days)->format('Y-m-d')
        ]);
    }
}
