<?php

use App\Livewire\CreateTour;
use Illuminate\Support\Facades\Route;
use Morilog\Jalali\Jalalian;

Route::get('/tours/create', CreateTour::class);


// Route::get('/calendar.csv', function() {
//     $keys = ['date', 'event_name', 'event_type', 'is_off'];
//     $csv = implode(',', $keys);

//     $months = json_decode(
//         // https://persian-calendar-api.sajjadth.workers.dev/
//         file_get_contents(database_path('/seeders/data/calendar.json'))
//     );
//     foreach ($months as $month) {
//         $days = collect($month->days);
//         $events = $days->filter(fn($x) => ! $x->disabled)
//             ->keyBy(
//                 fn($x) => new Jalalian(1404, 1, intval(convert_numbers($x->day->jalali, false)))->toCarbon()->format('Y-m-d')
//             )->map(function ($x) {
//                 return collect($x->events->list)->map(fn($d) => [
//                     'is_off' => $d->isHoliday ? '1' : '0',
//                     'event_name' => $d->event,
//                     'event_type' =>  $d->calendarType
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
//     }

//     return response($csv)->withHeaders([
//         'Content-Type' => 'text/csv'
//     ]);
// });