<?php

namespace Database\Seeders;

use App\Models\Airport;
use App\Utils\CSVReader;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AirportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $airports = new CSVReader(database_path('seeders/data/airports.csv'), ['str', 'str', 'str', 'str', 'str'])
            ->read()
            ->getData();

        $airports = collect($airports)->filter(fn($x) => $x['country_code'])->map(function($x) {
            $x['country_code'] = strtoupper($x['country_code']);
            return $x;
        })->toArray();

        DB::transaction(function() use($airports) {
            $chunks = collect($airports)->chunk(10);
            foreach ($chunks as $chunk) {
                Airport::insert($chunk->toArray());
            }
        });
    }
}
