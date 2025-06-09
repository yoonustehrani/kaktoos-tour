<?php

namespace App\Livewire;

use App\Enums\TourPaymentType;
use App\Livewire\Forms\DestinationForm;
use App\Livewire\Forms\TourForm;
use App\Models\Location;
use App\Models\TourDestination;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session as LaravelSession;
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

    #[On('undo-airline-item-selected')]
    public function removeAirlineCode() {
        $this->form->airline_code = null;
    }

    #[On('undo-origin-item-selected')]
    public function removeOriginId() {
        $this->form->origin_id = null;
    }

    public function submit()
    {
        switch ($this->step) {
            case 1:
                if ($this->photo) {
                    $this->form->image_src = $this->photo->storePublicly('tours', 'public');
                }
                break;
            case 2:
                $this->form->slug = slugify($this->form->title);
                $this->form->published_at = null;
                break;
        }
        $this->form->validate(
            TourForm::validation_rules()[$this->step]
        );
        if ($this->step === 2) {
            try {
                $this->form->save();
                swal(__('Tour was created successfully.'));
                $params = ['tour' => $this->form->tour->id, 'section' => 'destinations'];
                $this->form->reset();
                $this->step = 1;
                $this->redirectAction(EditTour::class, $params, navigate: true);
            } catch (\Throwable $th) {
                Log::error($th);
                swal(__('Tour was failed to be created.'), 'error');
                $this->redirectRoute('tours.create', navigate: true);
            }
        }
        $this->incrementStep();
    }
}
