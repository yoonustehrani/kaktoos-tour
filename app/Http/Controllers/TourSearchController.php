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
        $query = Tour::active()->select('tours.*');

        $orderBy = TourSearchOrder::tryFrom($request->order_by) ?? TourSearchOrder::BY_START_DATE;
        $sort = $request->sort ?: 'asc';

        $this->applyFiltersToQuery($query, $request, requires_dates_join: $orderBy == TourSearchOrder::BY_START_DATE);

        switch ($orderBy) {
            case TourSearchOrder::BY_START_DATE:
                $query->orderBy('earliest_start_date', $sort);
                break;
            case TourSearchOrder::BY_PRICE:
                $query->orderBy('min_adult_price', $sort);
                break;
            case TourSearchOrder::BY_NIGHTS:
                $query->orderBy('number_of_nights', $sort);
                break;
            case TourSearchOrder::BY_HOTEL_STARS:
                // TODO
                break;
            case TourSearchOrder::BY_HOTEL_RATES:
                // TODO
                break;
        }
        // return $query->get();
        
        $aggregate = DB::table(DB::raw("({$query->toSql()}) as aggregate_table"))
            ->mergeBindings($query->getQuery());
        // return [
        //     'max' => $aggregate->max('min_adult_price'),
        //     'min' => $aggregate->min('min_adult_price'),
        //     'tours' => $query->paginate(10)
        // ];
        $tours = $query->with([
            // 'origin',
            // 'destinations' => fn(HasMany $relation) => $relation->orderBy('order')->with('location'),
            'dates' => function(HasMany $relation) { 
                $relation->onlyUpcoming()->join('pricing_list_tour_date as ptd', 'tour_dates.id', '=', 'ptd.tour_date_id')
                    ->join('pricing_lists as pl', 'ptd.pricing_list_id', '=', 'pl.id')
                    ->orderBy('start_date')
                    ->select('tour_dates.*', 'pl.min_adult_price', 'pl.min_adult_price_display');
            }
        ]);
        return [
            'meta' => [
                'price' => [
                    'max' => $aggregate->max('min_adult_price_max'),
                    'min' => $aggregate->min('min_adult_price'),
                ]
            ],
            'results' => $tours->simplePaginate($request->per_page),
        ];
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
                // excludes tours without price
                $join->join('pricing_list_tour_date as ptd', 'dates.id', '=', 'ptd.tour_date_id')
                    ->join('pricing_lists as pl', 'ptd.pricing_list_id', '=', 'pl.id');
                
                if (! ($request->has('start_date') || $request->has('end_date'))) 
                    return;
                switch (true) {
                    case $request->has('start_date') && $request->has('end_date'):
                        $join->whereBetween('dates.start_date', [$request->start_date, $request->end_date])
                            ->whereBetween('dates.end_date', [$request->start_date, $request->end_date]);
                        break;
                    case $request->has('start_date'):
                        $join->where('dates.start_date', '>=', $request->start_date);
                        break;
                    case $request->has('end_date'):
                        $join->where('dates.end_date', '<=', $request->start_date);
                        break;
                }
            });
            $query->addSelect(DB::raw("MIN(dates.start_date) as earliest_start_date"));
            $query->addSelect(DB::raw("MIN(pl.min_adult_price) as min_adult_price"));
            $query->addSelect(DB::raw("MAX(pl.min_adult_price) as min_adult_price_max"));
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

        if ($request->has('term')) {
            $query->whereLike('title', '%' . $request->term .  '%');
        }
    }
}
