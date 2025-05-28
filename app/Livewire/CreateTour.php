<?php

namespace App\Livewire;

use App\Enums\TourPaymentType;
use App\Livewire\Forms\DestinationForm;
use App\Livewire\Forms\TourForm;
use App\Models\Location;
use App\Models\TourDestination;
use Illuminate\Validation\Rule;
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

    // public DestinationForm $destination_form;

    // public $displayDialog = false;


    // public function toggleDisplay()
    // {
    //     $this->displayDialog = ! $this->displayDialog;
    // }

    // #[Session('dest1')]
    // public array $destinations = [];

    #[Session('tour-form-step')]
    public int $step = 1;

    #[Validate('image|max:1024')] // 1MB Max
    public $photo;

    public array $steps = [
        'Tour Initial Data',
        'Tour Metadata',
        // 'Origin and Destinations',
        // 'Dates and Journey',
        // 'Hotel Packages and Pricing'
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

    // #[On('destination-item-selected')]
    // public function setLocationId($id) {
    //     $this->destination_form->location_id = intval($id);
    // }

    // public function removeDestination($id) {
    //     $this->destinations = collect($this->destinations)->filter(fn($x) => $x['id'] !== intval($id))->toArray();
    // }

    // public function addDestination()
    // {
    //     $this->destination_form->validate();
    
    //     $this->destinations[] = [
    //         'id' => random_int(1_000_000, 999_999_999),
    //         'location_id' => $this->destination_form->location_id,
    //         'location' => Location::find($this->destination_form->location_id)->toArray(),
    //         'number_of_nights' => $this->destination_form->number_of_nights,
    //         'requires_visa' => $this->destination_form->requires_visa,
    //         'visa_preparation_days' => $this->destination_form->visa_preparation_days,
    //     ];
        
    //     $this->destination_form->reset();
    //     $this->displayDialog = false;
    // }

    public function submit()
    {
        // $this->form->valida;
        // $this->validate();
        switch ($this->step) {
            case 1:
                if ($this->photo) {
                    $this->form->image_url = 'storage/' . $this->photo->storePublicly('tours', 'public');
                }
                break;
            case 2:
                $this->form->slug = slugify($this->form->title);
                $this->form->published_at = now();
                break;
            case 3:

        }
        $this->form->validate(
            $this->validation_rules()[$this->step]
        );
        $this->incrementStep();
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

    /**
     * @return array Array of Validation rules for each step
     */
    protected function validation_rules()
    {
        return [
            1 => [
                'title' => 'required|string|min:3|max:120',
                'number_of_nights' => 'required|int|min:0|max:20',
                'airline_code' => 'required|string|min:2|max:3|exists:airlines,code',
                'image_url' => 'required|string'
            ],
            2 => [
                'is_inbound' => 'required|boolean',
                'payment_type' => ['required', Rule::enum(TourPaymentType::class)],
                'origin_id' => 'required|exists:locations,id',
                'description' => 'nullable|string|min:3|max:500',
                'return_policy' => 'nullable|string|min:3|max:500',
                'required_documents' => 'nullable|string|min:3|max:500',
                'services' => 'nullable|string|min:3|max:500',
                'installment_policy' => 'required_if:payment_type,I|string|min:3|max:500'
            ],

            3 => [
                'slug' => 'required|unique:tours,slug|string|min:2|max:150',
                'published_at' => 'required|after:now'
            ]
        ];
    }
}
