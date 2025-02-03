<?php

use App\Http\Controllers\OriginSearchController;
use App\Http\Controllers\TourSearchController;
use App\Models\Country;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/countries', function() {
    return Country::simplePaginate(10);
});

Route::get('/countries/{countryCode}/locations', function(string $countryCode) {
    return Location::from($countryCode)->get();
})->where('countryCode', '[A-Z]{2}');

Route::get('locations/origin/search', OriginSearchController::class);

Route::post('tours/search', TourSearchController::class)->middleware('throttle:10,1');