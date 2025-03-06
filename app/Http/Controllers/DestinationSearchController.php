<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DestinationSearchController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'country_code' => ['string', 'regex:' . COUNTRY_CODE_REGEX],
            'limit' => ['numeric', 'min:1', 'max:20'],
            'term' => ['string', 'min:2', 'max:20']
        ]);

        $query = Location::notOrigin()->limit(
            $request->limit ?? 5
        )
        ->withCount('tours');
        
        if ($request->query('country_code')) {
            $query->from($request->query('country_code'));
        }

        if ($request->query('term')) {
            $query->whereLike('name_fa', "%{$request->term}%")
                ->orWhereLike('name', "%{$request->term}%");
            $query->orWhereHas('country', function(Builder $q) use($request) {
                $q->whereLike('name_fa', "%{$request->term}%")
                    ->orWhereLike('name', "%{$request->term}%");
            });
        } else {
            $query->orderBy('tours_count', 'desc');
        }

        return $query->with('country')->get()->groupBy('country_code');

        // if ($request->query('groupped')) {
        //     return $response->groupBy('country_code');
        // }

        // return $response;
    }
}
