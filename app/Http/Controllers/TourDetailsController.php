<?php

namespace App\Http\Controllers;

use App\Http\Resources\TourResource;
use App\Models\Tour;
use Illuminate\Http\Request;

class TourDetailsController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, string $id)
    {
        $tour = Tour::whereId($id);

        $tour->with(['origin', 'destinations' => function($q) {
            $q->join('locations as l', 'l.id', '=', 'tour_destinations.location_id')->orderBy('order');
        }, 'dates' => function($q) {
            $q->onlyUpcoming()->join('pricing_list_tour_date as ptd', 'tour_dates.id', '=', 'ptd.tour_date_id')
                ->join('pricing_lists as pl', 'ptd.pricing_list_id', '=', 'pl.id')
                ->orderBy('start_date')
                ->select('tour_dates.*', 'pl.min_adult_price', 'pl.min_adult_price_display');
            $q->with(['pricing_lists' => function($q) {
                $q->with('package.hotels', 'pricings');
            }]);
        }]);

        return response()->json(
            new TourResource($tour->firstOrFail())
        );
    }
}
