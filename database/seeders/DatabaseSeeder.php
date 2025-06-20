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
        $user = new User();
        $user->email = 'yoonustehraniam@gmail.com';
        $user->name = 'Yoonus Tehrani';
        $user->password = bcrypt(env('USER_DEFAULT_PASSWORD', 'password'));
        $user->email_verified_at = now();
        $user->save();

        $this->call(CountrySeeder::class);
        $this->call(AirlineSeeder::class);
        $this->call(AirportSeeder::class);
        $this->call(LocationSeeder::class);
        $this->call(HolidaySeeder::class);
        $this->call(ClassificationSeeder::class);
        // $this->call(LocationSeeder::class);
        // $this->call(TourSeeder::class);
    }
}
