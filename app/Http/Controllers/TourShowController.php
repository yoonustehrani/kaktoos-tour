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
        $tour->with('origin', 'destinations', 'dates');
        return $tour->first();
    }
}
