<?php

namespace App\Http\Controllers;

use App\Http\Requests\OriginSearchRequest;
use App\Models\Location;
use Illuminate\Http\Request;

class OriginSearchController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(OriginSearchRequest $request)
    {
        $query = Location::origin()->withCount('toursFrom');
        if ($request->term) {
            $query->whereLike('name_fa', "%{$request->term}%")
                ->orWhereLike('name', "%{$request->term}%");
        } else {
            $query->orderBy('tours_from_count', 'desc');
        }
        return $query->limit(
            $request->limit ?? 10
        )->get();
    }
}
