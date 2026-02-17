<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function index()
    {
        $countries = Country::query()
            ->select('countries.*')
            ->selectRaw('COUNT(DISTINCT tour_destinations.tour_id) as tours_count')
            ->where('code', '<>', 'IR')
            ->join('locations', 'locations.country_code', '=', 'countries.code')
            ->join('tour_destinations', 'tour_destinations.location_id', '=', 'locations.id')
            ->groupBy('countries.code')
            ->orderBy('countries.name_fa')
            ->get();
        $countries->load([
            'locations' => function($q) {
                $q->withCount('tours');
            }
        ]);
        return $countries;
        // return Country::whereHas('locations')->get();
    }
}
