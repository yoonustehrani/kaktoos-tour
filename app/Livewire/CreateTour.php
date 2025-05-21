<?php

namespace App\Livewire;

use App\Livewire\Forms\DestinationForm;
use App\Livewire\Forms\TourForm;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\On;
use Livewire\Attributes\Session;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateTour extends Component
{
    use WithFileUploads;

    public TourForm $form;

    public DestinationForm $destination_form;

    #[Session]
    public ?Collection $destinations;

    #[Session('tour-form-step')]
    public int $step = 1;

    #[Validate('image|max:1024')] // 1MB Max
    public $photo;

    public array $steps = [
        'Tour Initial Data',
        'Tour Metadata',
        'Origin and Destinations',
        'Dates and Journey',
        'Hotel Packages and Pricing'
    ];

    public function decrementStep() {
        $this->step = $this->step - 1 ?: 1;
    }

    public function incrementStep() {
        if ($this->step < count($this->steps)) {
            $this->step++;
        }
    }

//    public function mount()
//    {
//        // $step = abs(intval(request()->query('step'))) ?: 1;
//        // $this->step = $step;
//    }

    public function render()
    {
        return view('livewire.create-tour')
            ->title(__('Create new tour'));
    }

    #[On('airline-item-selected')]
    public function setAirlineCode($id) {
        $this->form->airline_code = $id;
    }

    #[On('origin-item-selected')]
    public function setOriginId($id) {
        $this->form->origin_id = $id;
    }

    public function submit()
    {
        $this->validate();
        $this->form->image_url = $this->photo->storePublicly('tours', 'public');
        $this->incrementStep();
    }
}
