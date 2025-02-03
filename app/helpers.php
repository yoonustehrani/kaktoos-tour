<?php

use App\Enums\Currencies;

define('SPACE', ' ');

if (! function_exists('slugify')) {
    function slugify(string $string): string {
        return str_replace(SPACE, '-', $string);
    }
}

if (! function_exists('random_price')) {
    function random_price(Currencies $currency = Currencies::IRT)
    {
        return match ($currency) {
            Currencies::IRT => fake()->numberBetween(10, 2000) * 100_000,
            Currencies::IRR => fake()->numberBetween(10, 2000) * 1_000_000,
            Currencies::USD, Currencies::EUR => fake()->numberBetween(1, 50) * 100,
        };
    }
}

if (! function_exists('convert_to_toman')) {
    function convert_to_toman(int $amount, Currencies $currency = Currencies::USD)
    {
        $exchange_rate = match ($currency) {
            Currencies::USD => 84_000,
            Currencies::EUR => 86_500,
            Currencies::IRR => 10,
        };
        return $amount * $exchange_rate;
    }
}