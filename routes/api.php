<?php

use App\Http\Controllers\CountrySearchController;
use App\Http\Controllers\DestinationSearchController;
use App\Http\Controllers\OriginSearchController;
use App\Http\Controllers\TourDateJourneyController;
use App\Http\Controllers\TourDetailsController;
use App\Http\Controllers\TourSearchController;
use App\Http\Controllers\TourShowController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/', function() {
    // return;
    return App\Models\Tour::select('id', 'number_of_nights')->get();
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('countries/search', CountrySearchController::class);

Route::get('locations/destination/search', DestinationSearchController::class);

Route::get('locations/origin/search', OriginSearchController::class);

Route::post('tours/search', TourSearchController::class)->middleware('throttle:10,1');

Route::get('tours/{id}', TourShowController::class);
Route::get('tours/{id}/details', TourDetailsController::class);
Route::get('tours/{tourId}/dates/{dateId}/journey', TourDateJourneyController::class);