<?php

namespace App\Livewire;

use App\Livewire\Forms\DestinationForm;
use App\Livewire\Forms\TourForm;
use App\Models\Location;
use App\Models\TourDestination;
use Livewire\Attributes\On;
use Livewire\Attributes\Session;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Ramsey\Uuid\Uuid;

class CreateTour extends Component
{
    use WithFileUploads;

    public TourForm $form;

    public DestinationForm $destination_form;

    public $displayDialog = false;


    public function toggleDisplay()
    {
        $this->displayDialog = ! $this->displayDialog;
    }

    #[Session('dest1')]
    public array $destinations = [];

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

    // public function mount()
    // {
    //     // if (! $this->destinations) {
    //     //     $this->destinations = collect([]);
    //     // }
    // }

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
        $this->form->origin_id = intval($id);
    }

    #[On('destination-item-selected')]
    public function setLocationId($id) {
        $this->destination_form->location_id = intval($id);
    }

    public function removeDestination($id) {
        $this->destinations = collect($this->destinations)->filter(fn($x) => $x['id'] !== intval($id))->toArray();
    }

    public function addDestination()
    {
        $this->destination_form->validate();
    
        $this->destinations[] = [
            'id' => random_int(1_000_000, 999_999_999),
            'location_id' => $this->destination_form->location_id,
            'location' => Location::find($this->destination_form->location_id)->toArray(),
            'number_of_nights' => $this->destination_form->number_of_nights,
            'requires_visa' => $this->destination_form->requires_visa,
            'visa_preparation_days' => $this->destination_form->visa_preparation_days,
        ];
        
        $this->destination_form->reset();
        $this->displayDialog = false;
    }

    public function submit()
    {
        // $this->validate();
        $this->form->image_url = $this->photo->storePublicly('tours', 'public');
        $this->incrementStep();
    }
}
