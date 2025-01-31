<?php

namespace App\Http\Controllers;

use App\Enums\TourSearchOrder;
use App\Http\Requests\TourSearchRequest;
use App\Models\Tour;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class TourSearchController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(TourSearchRequest $request)
    {
        /**
         * @var \Illuminate\Database\Eloquent\Builder
         */
        $query = Tour::onlyActive()->select('tours.*');

        $orderBy = TourSearchOrder::tryFrom($request->order_by) ?? TourSearchOrder::BY_START_DATE;
        $sort = $request->sort ?: 'asc';

        $this->applyFiltersToQuery($query, $request, requires_dates_join: $orderBy == TourSearchOrder::BY_START_DATE);

        switch ($orderBy) {
            case TourSearchOrder::BY_START_DATE:
                $column_select = 'MIN(dates.start_date)';
                $column_name = 'earliest_start_date';
                $query->addSelect(DB::raw("{$column_select} as {$column_name}"))->orderBy($column_name, $sort);
                break;
            case TourSearchOrder::BY_PRICE:
                // TODO
                break;
            case TourSearchOrder::BY_HOTEL_STARS:
                // TODO
                break;
            case TourSearchOrder::BY_HOTEL_RATES:
                // TODO
                break;
        }
        
        // return $query->get();
        return $query->with([
            'origin',
            'destinations' => fn(HasMany $relation) => $relation->orderBy('order')->with('location'),
            'dates' => fn(HasMany $relation) => $relation->orderBy('start_date')->onlyUpcoming()
        ])->simplePaginate(10);
    }

    public function applyFiltersToQuery(Builder &$query, Request &$request, bool $requires_dates_join)
    {
        /**
         * Filters out tours based on date parameters
         * a list of origin ids compared against tours.origin_id
         */
        if (
            ($request->has('start_date') || $request->has('end_date')) // at least a date is provided
            ||
            $requires_dates_join // no date may be provided yet the date is needed for sorting
        ) {
            $query->join('tour_dates as dates', function(JoinClause $join) use($request) {
                $join->on('tours.id', '=', 'dates.tour_id');
                if (! ($request->has('start_date') || $request->has('end_date'))) 
                    return;
                switch (true) {
                    case $request->has('start_date') && $request->has('end_date'):
                        $join->whereBetween('td.start_date', [$request->start_date, $request->end_date])
                        ->whereBetween('td.end_date', [$request->start_date, $request->end_date]);
                        break;
                    case $request->has('start_date'):
                        $join->where('dates.start_date', '>=', $request->start_date);
                        break;
                    case $request->has('end_date'):
                        $join->where('dates.end_date', '<=', $request->start_date);
                        break;
                }
            });

            $query->groupBy('tours.id')
                ->distinct();
        }
        /**
         * Filters out tours based on origins parameter
         * a list of location ids compared against tours.origin_id
         */
        if ($request->has('origins') && !is_null($request->countries) && count($request->origins)) {
            $query->whereIn('origin_id', $request->origins);
        }

        /**
         * Filters out tours based on origins parameter
         * a list of location ids compared against tours.destinations.location_id
         */
        if ($request->has('destinations') && !is_null($request->destinations) && count($request->destinations)) {
            $query->whereHas('destinations', function(Builder $query) use($request) {
                $query->whereIn('location_id', $request->destinations);
            });
        }

        /**
         * Filters out tours based on countries parameter
         * a list of country codes compared against tours.destinations.location.country_code
         */
        if ($request->has('countries') && !is_null($request->countries) && count($request->countries)) {
            $query->whereHas('destinations.location', function(Builder $query) use($request) {
                $query->whereIn('country_code', $request->countries);
            });
            // $query->join('tour_destinations as tdest', function(JoinClause $join) use($request) {
            //     $join->on('tours.id', '=', 'tdest.tour_id')
            //         ->join('locations as l', function(JoinClause $xjoin) use($request) {
            //             $xjoin->on('tdest.location_id', '=', 'l.id')
            //                 ->whereIn('l.country_code', $request->countries);
            //         });
            // });
        }
    }
}
