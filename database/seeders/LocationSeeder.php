<?php

namespace Database\Seeders;

use App\Models\Location;
use App\Utils\CSVReader;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use ParseCsv\Csv;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $locations = new CSVReader(database_path('seeders/data/locations.csv'), ['str', 'str', 'str', 'bool'])
            ->read()
            ->getData();
        DB::transaction(function() use($locations) {
            Location::insert($locations);
        });
    }
}
