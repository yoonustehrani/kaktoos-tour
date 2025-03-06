<?php

namespace App\Http\Controllers;

use App\Models\JourneyCourse;
use App\Models\TourDate;
use Illuminate\Http\Request;

class TourDateJourneyController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, string $tourId, string $dateId)
    {
        return response()->json(
            JourneyCourse::whereTourId($tourId)
            ->whereTourDateId($dateId)
            ->with('origin', 'destination')
            ->with('transportation_firm', 'departure', 'arrival')
            ->get()
        );
    }
}
