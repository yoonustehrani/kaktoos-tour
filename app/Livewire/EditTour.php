<?php

namespace App\Livewire;

use App\Livewire\Forms\TourForm;
use App\Models\Tour;
use App\Traits\DestinationSectionMethods;
use Illuminate\Support\Carbon;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditTour extends Component
{

    use DestinationSectionMethods, WithFileUploads;

    public TourForm $tour_form;

    public $section;
    public $section_name;

    #[Validate('image|max:1024')] // 1MB Max
    public $photo;

    protected $title;

    protected $sections = [
        'Overview',
        'initial-data' => 'Tour Initial Data',
        'meta-data' => 'Tour Metadata',
        'destinations' => 'Tour Destinations',
        'page-config' => 'Page Config'
    ];

    public function mount(Tour $tour, ?string $section = null)
    {
        $this->section = $section ?? 'overview';
        $this->section_name = $this->sections[$section ?? 0];
        $this->tour_form->setTour($tour);
        $this->destinations = $tour->destinations()->get();
        $this->title = __($this->section_name) . ' - ' . __('Editing :item', ['item' => $tour->title]);
    }

    public function changePublishedAtTime(string $time)
    {
        [$hour, $minute] = explode(':', $time);
        if (is_null($this->tour_form->published_at)) {
            $this->tour_form->published_at = Carbon::instance(now());
        }
        $this->tour_form->published_at->setHour(intval($hour))->setMinute(intval($minute));
    }

    public function changePublishedAtDate(string $date)
    {
        [$year, $month, $day] = explode('-', $date);
        if (is_null($this->tour_form->published_at)) {
            $this->tour_form->published_at = Carbon::instance(now());
        }
        $this->tour_form->published_at->setDate(intval($year), intval($month), intval($day));
    }

    public function addDestination()
    {
        $this->destination_form->validate();
        $this->destinations->push($this->destination_form->save($this->tour_form->tour));
        $this->destination_form->reset();
        $this->displayDialog = false;
    }

    public function render()
    {
        return view('livewire.edit-tour')->title($this->title);
    }

    public function submitInitialData()
    {
        if ($this->photo) {
            $this->tour_form->image_src = 'storage/' . $this->photo->storePublicly('tours', 'public');
        }
        $this->tour_form->validate(
            TourForm::validation_rules()[1]
        );
        try {
            $this->tour_form->save();
            swal(__('Edited successfully.'));
            $this->redirectRoute('tours.edit', ['tour' => $this->tour_form->tour->id]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function submitMetaData()
    {
        $this->tour_form->validate(
            TourForm::validation_rules()[2]
        );
        try {
            $this->tour_form->save();
            swal(__('Edited successfully.'));
            $this->redirectRoute('tours.edit', ['tour' => $this->tour_form->tour->id]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function submitPageConfig()
    {
        $this->tour_form->validate(
            TourForm::validation_rules(['id' => $this->tour_form->tour->id])[3]
        );
        try {
            $this->tour_form->save();
            swal(__('Edited successfully.'));
            $this->redirectRoute('tours.edit', ['tour' => $this->tour_form->tour->id]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
