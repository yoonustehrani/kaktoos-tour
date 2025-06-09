<?php

use App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('countries/search', Controllers\CountrySearchController::class);

Route::get('locations/destination/search', Controllers\DestinationSearchController::class);

Route::get('locations/origin/search', Controllers\OriginSearchController::class);

Route::post('tours/search', Controllers\TourSearchController::class)->middleware('throttle:10,1');

Route::get('tours/{id}', Controllers\TourShowController::class);
Route::get('tours/{id}/details', Controllers\TourDetailsController::class);
Route::get('tours/{tourId}/dates/{dateId}/journey', Controllers\TourDateJourneyController::class);

Route::get('categories', Controllers\CategoryListController::class);