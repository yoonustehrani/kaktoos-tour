<?php

namespace Database\Factories;

use App\Enums\Currencies;
use App\Enums\TourRoomTypes;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pricing>
 */
class PricingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'room_type' => fake()->randomElement(TourRoomTypes::cases())
        ];
    }

    public function currency(Currencies $currency)
    {
        return [
            'price' => match ($currency) {
                Currencies::IRT => fake()->numberBetween(10, 2000) * 100_000,
                Currencies::IRR => fake()->numberBetween(10, 2000) * 1_000_000,
                Currencies::USD, Currencies::EUR => fake()->numberBetween(1, 50) * 100,
            },
            'currency' => $currency
        ];
        // return $this->state(function(array $attributes) use($currency) {
            
        // });
    }
}
