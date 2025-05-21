<?php

namespace App\Livewire\Forms;

use App\Models\TourDestination;
use Livewire\Attributes\Validate;
use Livewire\Form;

class DestinationForm extends Form
{
    public ?TourDestination $destination;

    public ?int $location_id;

    public int $number_of_nights = 0;

    public bool $requires_visa = false;

    public ?int $visa_preparation_days;
}
