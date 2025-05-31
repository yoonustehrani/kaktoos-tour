<?php

namespace App\Livewire;

use App\Models\Holiday;
use Illuminate\Support\Carbon;
use Livewire\Component;
use Morilog\Jalali\Jalalian;

class Calendar extends Component
{
    protected $month;
    protected $year;
    public Carbon $carbon;
    public array $jalali;
    public $weekdays = [];
    public $gregorian = false;

    public function mount()
    {
        $this->weekdays = [
            'Saturday' => 'Sat',
            'Sunday' => 'Sun',
            'Monday' => 'Mon',
            'Tuesday' => 'Tue',
            'Wednesday' => 'Wed',
            'Thursday' => 'Thu',
            'Friday' => 'Fri'
        ];
        $this->carbon = Carbon::create(year: now()->year, month: now()->month, day: 1);
        $this->jalali = [jdate()->getYear(), jdate()->getMonth(), 1];
    }

    protected function getJalali()
    {
        return new Jalalian(...$this->jalali);
    }

    public function getMonthName()
    {
        return $this->gregorian ? $this->carbon->isoFormat('MMM, YYYY') : $this->getJalali()->format('Y %B');
    }

    public function getCarbon()
    {
        return $this->carbon->locale('en');
    }

    public function nextMonth()
    {
        if ($this->gregorian) {
            $this->carbon->addMonth();
        } else {
            $j = $this->getJalali()->addMonths(1);
            $this->jalali = [$j->getYear(), $j->getMonth(), 1];
        }
    }

    public function prevMonth()
    {
        if ($this->gregorian) {
            $this->carbon->subMonth();
        } else {
            $j = $this->getJalali()->subMonths(1);
            $this->jalali = [$j->getYear(), $j->getMonth(), 1];
        }
    }

    public function generateCalendar()
    {
        $calendar = [];
        
        if ($this->gregorian) {
            $date = $this->getCarbon();
            $startOfMonth = $date->copy()->startOfMonth();
            $endOfMonth = $date->copy()->endOfMonth();

            // Start calendar on Sunday (or Monday if you prefer)
            $startDate = $startOfMonth->copy()->startOfWeek(6);
            $endDate = $endOfMonth->copy()->endOfWeek();
            $current = $startDate->copy();
            $events = Holiday::whereBetween('date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])->get()->groupBy('date')->toArray();
            while ($current <= $endDate) {
                $week = [];
                for ($i = 0; $i < 7; $i++) {
                    $week[] = [
                        'date' => $current->copy(),
                        'isCurrentMonth' => $current->month === $date->month,
                        'isToday' => $current->isToday(),
                        'events' => $events[$current->format('Y-m-d')] ?? []
                    ];
                    $current->addDay();
                }
                $calendar[] = $week;
            }
        } else {
            $date = jdate();
            $startOfMonth = $this->getJalali()->toCarbon();
            $endOfMonth = $this->getJalali()->getEndDayOfMonth()->toCarbon();
            $startDate = $startOfMonth->copy()->startOfWeek(6);
            $endDate = $endOfMonth->copy()->endOfWeek();
            $current = $startDate->copy();
            $events = Holiday::whereBetween('date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])->get()->groupBy('date')->toArray();
            while ($current <= $endDate) {
                $week = [];
                for ($i = 0; $i < 7; $i++) {
                    $j = Jalalian::fromCarbon($current->copy());
                    $week[] = [
                        'date' => $j,
                        'isCurrentMonth' => $j->getMonth() === $this->getJalali()->getMonth(),
                        'isToday' => $current->isToday(),
                        'events' => $events[$current->format('Y-m-d')] ?? []
                    ];
                    $current->addDay();
                }
                $calendar[] = $week;
            }
        }
        return $calendar;
    }

    public function render()
    {
        return view('livewire.calendar', [
            'calendar' => $this->generateCalendar()
        ]);
    }
}
