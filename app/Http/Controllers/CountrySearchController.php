<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Location;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CountrySearchController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'limit' => ['numeric', 'min:1', 'max:50'],
            'term' => ['string', 'min:3', 'max:15']
        ]);

        $query = Country::where('code', '<>', 'IR')->select('countries.*');
        if ($request->has('term')) {
            $query->whereLike('countries.name_fa', "%{$request->term}%")
                ->orWhereLike('countries.name', "%{$request->term}%");
        }
        $query->leftJoin('locations as l', function(JoinClause $join) {
            $join->on('countries.code', '=', 'l.country_code');
            $join->leftJoin('tour_destinations as td', 'l.id', '=', 'td.location_id')
                ->leftJoin('tours as t', 'td.tour_id', '=', 't.id')
                ->where('t.active', true);
        });
        $query->addSelect(DB::raw('COUNT(DISTINCT t.id) as tours_count'));
        return $query->groupBy('countries.code', 'countries.name')
        ->orderBy('tours_count', 'desc')->limit(
            $request->limit ?? 10
        )->get();
    }
}
