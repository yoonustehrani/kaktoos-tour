<?php

namespace Database\Seeders;

use App\Models\Airline;
use App\Utils\CSVReader;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AirlineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $airlines = new CSVReader(database_path('seeders/data/airlines.csv'), ['str', 'str', 'str', 'str', 'str'])
            ->read()
            ->getData();

        DB::transaction(function() use($airlines) {
            Airline::insert($airlines);
        });
    }
}
