<?php

namespace App\Livewire\Forms;

use App\Models\Tour;
use App\Models\TourDestination;
use Livewire\Attributes\Validate;
use Livewire\Form;

class DestinationForm extends Form
{
    // public TourDestination $destination;

    #[Validate('required|int|min:1')]
    public ?int $location_id;

    #[Validate('required|int|min:1')]
    public ?int $number_of_nights;

    #[Validate('required|boolean')]
    public bool $requires_visa = false;

    #[Validate('nullable|int|min:1')]
    public ?int $visa_preparation_days = null;

    public function save(Tour $tour)
    {
        $destination = new TourDestination();
        $destination->fill($this->toArray());
        $order = $tour->destinations()->max('order');
        $destination->order = $order ? $order + 1 : 0;
        return $tour->destinations()->save($destination);
    }
}
