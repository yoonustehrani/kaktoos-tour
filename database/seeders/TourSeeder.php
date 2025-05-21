<?php

namespace Database\Seeders;

use App\Enums\Currencies;
use App\Enums\TourPaymentType;
use App\Enums\TourRoomTypes;
use App\Events\PricingListUpdated;
use App\Models\Airline;
use App\Models\Airport;
use App\Models\Hotel;
use App\Models\JourneyCourse;
use App\Models\Location;
use App\Models\Pricing;
use App\Models\PricingList;
use App\Models\Tour;
use App\Models\TourDate;
use App\Models\TourDestination;
use App\Models\TourPackage;
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
        $countries = ['DE', 'FR', 'TH', 'IT', 'TR'];
        foreach ($countries as $country) {
            $date = fake()->dateTimeBetween('+2 days', '+30 days')->format('Y-m-d');
            $days = random_int(4, 11);
            $locations =  Location::notOrigin()->from($country)->inRandomOrder()->select('id', 'name')->limit(3)->get();
            if ($locations->count() == 0) {
                continue;
            }
            $origin_location = Location::whereIsOrigin(true)->first();
            $airline = Airline::whereCode('B9')->first();

            $tour = Tour::factory(count: 1, state: [
                'origin_id' => $origin_location,
                'number_of_nights' => $days - 1,
                'airline_code' => $airline,
                'payment_type' => fake()->randomElement(TourPaymentType::cases()),
                'is_inbound' => false
            ])->country($country)->state(function ($state) use($date) {
                $title = $state['title'] . " " . \Morilog\Jalali\Jalalian::fromCarbon(Carbon::createFromFormat('Y-m-d', $date))->format('%B %Y');
                return [
                    'title' => $title,
                    'slug' => str_ireplace(' ', '-', $title)
                ];
            })->has(
                factory: TourDate::factory()->count(2)
                    ->state(new Sequence(fn (Sequence $sequence) => [
                        'start_date' => Carbon::createFromFormat('Y-m-d', $date)->addDays($sequence->index)->format('Y-m-d')
                    ]))->days($days),
                relationship: 'dates'
            )->has(
                factory: TourDestination::factory()->count($locations->count())->state(
                    new Sequence(function(Sequence $sequence) use($locations, $days) {
                        $d = floor($days / $locations->count()) ?: 1;
                        $last = $locations->count() == ($sequence->index + 1);
                        if ($last) {
                            $d = floor($days / $locations->count());
                            $d += $days - ($d * $locations->count());
                        }
                        return [
                            'location_id' => $locations->pluck('id')->toArray()[$sequence->index],
                            'number_of_nights' => $last ? ((intval($d) - 1) ?: 1) : intval($d),
                            'order' => $sequence->index
                        ];
                    })
                ),
                relationship: 'destinations'
            )->has(
                factory: TourPackage::factory()->hasAttached(
                    Hotel::factory($locations->count())->state(new Sequence(fn (Sequence $sequence) => [
                        'location_id' => $locations[$sequence->index]->id
                    ])),
                    ['service' => 'ALL', 'room_style' => 'STANDARD']
                ),
                relationship: 'packages'
            )->create()->first();
            $package = $tour->packages()->first();

            foreach ($tour->dates()->get() as $date) {
                $list = new PricingList();
                $list->package()->associate($package);
                $tour->pricing_lists()->save($list);
                
                $cources = $date->journey_courses()->saveMany(JourneyCourse::factory($locations->count() + 1)->state(new Sequence(fn(Sequence $sequence) => [
                    'origin_location_id' => $sequence->index == 0 ? $origin_location->id : $locations[$sequence->index - 1]->id,
                    'destination_location_id' => $locations[$sequence->index]->id ?? $origin_location->id,
                    'tour_id' => $tour->id,
                    'order' => $sequence->index
                ]))->make());

                foreach ($cources as $course) {
                    $course->transportation_firm()->associate($airline);
                    $course->departure()->associate(Airport::inRandomOrder()->where('country_code', $country)->first());
                    $course->arrival()->associate(Airport::inRandomOrder()->where('country_code', $country)->first());
                    $course->save();
                }

                $pricings = collect([]);
                $room_types = [TourRoomTypes::Single, TourRoomTypes::Double]; // , TourRoomTypes::ChildWithoutBed, TourRoomTypes::ChildWithBed, TourRoomTypes::Infant
                foreach ($room_types as $room_type) {
                    Pricing::factory(2, state: ['room_type' => $room_type])->state(new Sequence(
                        ['currency' => Currencies::IRT, 'price' => random_price(Currencies::IRT)],
                        ['currency' => Currencies::USD, 'price' => random_price(Currencies::USD)],
                    ))->make()->each(fn($item) => $pricings->push($item));
                }
                $list->pricings()->saveMany($pricings);
                $list->dates()->sync($date->id);
                PricingListUpdated::dispatch($list);
            }
        }
    }
}
