<?php

use App\Livewire\CreateTour;
use App\Livewire\EditTour;
use Illuminate\Support\Facades\Route;

Route::middleware([\Filament\Http\Middleware\Authenticate::class])->group(function() {
    Route::get('/tours/create', CreateTour::class)->name('tours.create');
    Route::get('/tours/{tour}/edit/{section?}', EditTour::class)->name('tours.edit');
});

// Route::get('/calendar.csv', function() {
//     $keys = ['date', 'event_name', 'event_type', 'is_off'];
//     $csv = implode(',', $keys);

//     $months = json_decode(
//         file_get_contents('https://persian-calendar-api.sajjadth.workers.dev/')
//     );
//     $i = 1;
//     foreach ($months as $month) {
//         $days = collect($month->days);
//         $events = $days->filter(fn($x) => ! $x->disabled)
//             ->keyBy(
//                 fn($x) => new Jalalian(1404, $i, intval(convert_numbers($x->day->jalali, false)))->toCarbon()->format('Y-m-d')
//             )->map(function ($x) {
//                 return collect($x->events->list)->map(fn($d) => [
//                     'event_name' => $d->event,
//                     'event_type' =>  $d->calendarType,
//                     'is_off' => $d->isHoliday ? '1' : '0',
//                 ])->toArray();
//             })->filter(fn($x) => count($x) > 0)->toArray();
//         foreach ($events as $date => $events) {
//             foreach ($events as $e) {
//                 $csv .= "\n" . implode(',', [
//                     'date' => $date,
//                     ...$e
//                 ]);
//             }
//         }
//         $i++;
//     }

    // return response($csv)->withHeaders([
    //     'Content-Type' => 'text/csv'
    // ]);
// });