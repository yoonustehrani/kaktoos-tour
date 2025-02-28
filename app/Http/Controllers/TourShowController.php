<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tour;

class TourShowController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, string $id)
    {
        $tour = Tour::whereId($id);

        $tour->with(['origin', 'destinations.location', 'dates' => function($q) {
            $q->with(['pricing_lists' => function($q) {
                $q->with('package.hotels', 'pricings');
            }, 'journey_courses' => function($jq) {
                $jq->with('transportation_firm', 'departure', 'arrival');
            }]);
        }]);
        return response()->json($tour->first());
    }
}
