<?php

namespace App\Livewire;

use App\Livewire\Forms\TourForm;
use App\Models\Tour;
use App\Traits\DestinationSectionMethods;
use Livewire\Component;

class EditTour extends Component
{

    use DestinationSectionMethods;

    public TourForm $tour_form;

    public $section;
    public $section_name;

    protected $title;

    protected $sections = [
        'Overview',
        'initial-data' => 'Tour Initial Data',
        'meta-data' => 'Tour Metadata',
        'destinations' => 'Tour Destinations'
    ];

    public function mount(Tour $tour, ?string $section = null)
    {
        $this->section = $section;
        $this->section_name = $this->sections[$section ?? 0];
        $this->tour_form->tour = $tour;
        $this->title = __($this->section) . ' - ' . __('Editing :item', ['item' => $tour->title]);
    }

    public function changePublishedAtTime(string $time)
    {
        [$hour, $minute] = explode(':', $time);
        $this->form->published_at->setHour(intval($hour))->setMinute(intval($minute));
    }

    public function changePublishedAtDate(string $date)
    {
        [$year, $month, $day] = explode('-', $date);
        $this->form->published_at->setDate(intval($year), intval($month), intval($day));
    }

    public function render()
    {
        return view('livewire.edit-tour')->title($this->title);
    }
}
