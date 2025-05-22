<?php

namespace Database\Seeders;

use App\Models\Holiday;
use App\Utils\CSVReader;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HolidaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $calendar = new CSVReader(database_path('seeders/data/calendar.csv'), ['str', 'str', 'str', 'bool'])
            ->read()
            ->getData();
        DB::transaction(function() use($calendar) {
            Holiday::insert($calendar);
        });
    }
}
