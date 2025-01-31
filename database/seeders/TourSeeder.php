<?php

namespace Database\Seeders;

use App\Models\Location;
use App\Models\Tour;
use App\Models\TourDate;
use App\Models\TourDestination;
use DateInterval;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Support\Carbon;

class TourSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $countries = ['DE', 'FR', 'TH'];
        foreach ($countries as $country) {
            $date = fake()->dateTimeBetween('+2 days', '+30 days')->format('Y-m-d');
            $days = random_int(4, 11);
            $locations =  Location::notOrigin()->from($country)->inRandomOrder()->select('id')->limit(3)->get();
            Tour::factory(count: 1, state: [
                'origin_id' => Location::whereIsOrigin(true)->first(),
                'number_of_nights' => $days - 1,
            ])->country($country)->has(
                factory: TourDate::factory()->count(3)->state(new Sequence(fn (Sequence $sequence) => [
                    'start_date' => Carbon::createFromFormat('Y-m-d', $date)->addDays($sequence->index)->format('Y-m-d')
                ]))->days($days),
                relationship: 'dates'
            )->has(
                factory: TourDestination::factory()->count($locations->count())->state(
                    new Sequence(function(Sequence $sequence) use($locations, $days) {
                        $d = floor($days / $locations->count());
                        if ($last = $locations->count() == $sequence->index + 1) {
                            $d += $days - ($d * $locations->count());
                        }
                        return [
                            'location_id' => $locations->pluck('id')->toArray()[$sequence->index],
                            'number_of_nights' => intval($d - 1),
                            'order' => $sequence->index
                        ];
                    })
                ),
                relationship: 'destinations'
            )->create();
        }
    }
}
