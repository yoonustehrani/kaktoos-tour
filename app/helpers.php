<?php

use App\Enums\Currencies;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

define('SPACE', ' ');
define('COUNTRY_CODE_REGEX', '/^[A-Z]{2}$/');

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

if (! function_exists('clone_query')) {
    function clone_query(Builder|QueryBuilder $builder): Builder|QueryBuilder
    {
        return clone $builder;
    }
}

if (! function_exists('aggregated_query')) {
    function aggregated_query(Builder|QueryBuilder $builder): QueryBuilder
    {
        $query = clone_query($builder);
        return DB::table(DB::raw("({$query->toSql()}) as aggregate_table"))
            ->mergeBindings($query->getQuery());
    }
}