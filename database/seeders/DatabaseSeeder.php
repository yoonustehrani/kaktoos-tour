<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(CountrySeeder::class);
        $this->call(AirlineSeeder::class);
        $this->call(AirportSeeder::class);
        $this->call(LocationSeeder::class);
        // $this->call(LocationSeeder::class);
        // $this->call(TourSeeder::class);
    }
}
