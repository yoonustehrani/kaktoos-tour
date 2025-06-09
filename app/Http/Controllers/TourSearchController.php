<?php

namespace App\Http\Controllers;

use App\Enums\TourSearchOrder;
use App\Http\Requests\TourSearchRequest;
use App\Models\Country;
use App\Models\Location;
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

        $this->applyFiltersToQuery($query, $request, requires_dates_join: true);

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
        $query->whereHas('dates', function($relation) {
            $relation->onlyUpcoming();
        });
        $tours = $query->with([
            'origin',
            'dates' => function(HasMany $relation) use($request) { 
                $relation->onlyUpcoming()->join('pricing_list_tour_date as ptd', 'tour_dates.id', '=', 'ptd.tour_date_id')
                    ->join('pricing_lists as pl', 'ptd.pricing_list_id', '=', 'pl.id')
                    ->orderBy('start_date')
                    ->select('tour_dates.*', 'pl.min_adult_price', 'pl.min_adult_price_display');
                if ($request->has('max_price')) {
                    $relation->where('pl.min_adult_price', '<=', $request->max_price);
                }
                if ($request->has('min_price')) {
                    $relation->where('pl.min_adult_price', '>=', $request->min_price);
                }
            },
            'destinations' => function(HasMany $relation) {
                $relation->join('locations as l', 'tour_destinations.location_id', '=', 'l.id');
            }
        ]);

        return [
            'meta' => $this->getMeta($query, $request),
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
                if ($request->has('max_price')) {
                    $join->where('pl.min_adult_price', '<=', $request->max_price);
                }
                if ($request->has('min_price')) {
                    $join->where('pl.min_adult_price', '>=', $request->min_price);
                }
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
            $query->groupBy('tours.id');
                // ->distinct();
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
        }

        /**
         * Filters out tours based on search term parameter
         * a string compared against tours.title
         */
        if ($request->has('term')) {
            $query->whereLike('title', '%' . $request->term .  '%');
        }

        /**
         * Filters out tours based on search term parameter
         * a string compared against tours.title
         */
        // && count($request->nights)
        if ($request->nights) {
            $query->whereIn('number_of_nights', [$request->nights]);
        }
    }

    public function getMeta(Builder &$query, Request &$request)
    {

        $tourIds = aggregated_query($query)->select('aggregate_table.id as id')->get()->pluck('id');

        $number_of_nights = DB::table('tours')->whereIn('id', $tourIds)
            ->select('number_of_nights as nights')
            ->addSelect(DB::raw('COUNT(number_of_nights) as tours_count'))
            ->groupBy('number_of_nights')
            ->orderBy('number_of_nights')
            ->get();


        $locationQuery = DB::table('locations')->join('tour_destinations as dest', function(JoinClause $join) use($tourIds) {
            $join->on('dest.location_id', '=', 'locations.id')->whereIn('dest.tour_id', $tourIds);
        });

        $destinations_with_count = clone_query($locationQuery)
            ->select([
                'locations.id',
                'locations.name',
                'locations.name_fa',
                'locations.country_code',
                DB::raw('COUNT(DISTINCT dest.tour_id) as tours_count')
            ])
            ->groupBy('locations.id')
            ->get();

        $countries_with_count = clone_query($locationQuery)
            ->join('countries as c', 'c.code', '=', 'locations.country_code')
            ->select( 'c.*', DB::raw('COUNT(DISTINCT dest.tour_id) as tours_count'))
            ->groupBy('c.code', 'c.name')
            ->get();

        $origins = Location::origin()
        ->join('tours as t', function(JoinClause $join) use($tourIds) {
            $join->on('t.origin_id', '=', 'locations.id')
                ->whereIn('t.id', $tourIds);
        })
        ->select('locations.*')->addSelect(DB::raw('COUNT(DISTINCT t.id) as tours_count'))
        ->groupBy('locations.id')
        ->get()->toArray();
        
        $price = aggregated_query($query)->select(
            DB::raw('min("min_adult_price") as min'),
            DB::raw('max("min_adult_price_max") as max')
        )->first();
        return array_merge([
            'destinations' => $destinations_with_count,
            'countries' => $countries_with_count
        ], compact('price', 'origins', 'number_of_nights'));
    }
}
