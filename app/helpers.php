<?php

use App\Enums\Currencies;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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


if (! function_exists('convert_numbers')) {
    /**
     * Converts between English and Persian (Arabic) digits
     * 
     * @param string $string The input string containing numbers to convert
     * @param bool $toPersian If true, converts English to Persian; if false, converts Persian to English
     * @return string The converted string
     */
    function convert_numbers($string, $toPersian = true) {
        $english = array('0','1','2','3','4','5','6','7','8','9');
        $persian = array('۰','۱','۲','۳','۴','۵','۶','۷','۸','۹');
        
        if ($toPersian) {
            return str_replace($english, $persian, $string);
        } else {
            return str_replace($persian, $english, $string);
        }
    }
}

if (! function_exists('swal')) {
    function swal($message, $level = 'success') {
        session()->flash('alert', compact('message', 'level'));
    }
}

if (! function_exists('get_file_url')) {
    function get_file_url(string $path)
    {
        return asset(Storage::url($path));
    }
}