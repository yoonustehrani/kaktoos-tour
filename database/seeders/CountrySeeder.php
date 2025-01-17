<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Utils\CSVReader;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $countries = new CSVReader(database_path('seeders/data/countries.csv'), ['str', 'str', 'str'])
            ->read()
            ->getData();
        DB::transaction(function() use($countries) {
            Country::insert($countries);
        });
    }
}
