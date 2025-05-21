<?php

use App\Livewire\CreateTour;
use Illuminate\Support\Facades\Route;

Route::get('/tours/create', CreateTour::class);