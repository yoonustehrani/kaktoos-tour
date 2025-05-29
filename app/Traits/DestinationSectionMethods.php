<?php

namespace App\Traits;

use App\Livewire\Forms\DestinationForm;
use App\Models\Location;
use Livewire\Attributes\On;
use Livewire\Attributes\Session;

trait DestinationSectionMethods
{

    public DestinationForm $destination_form;

    public $displayDialog = false;

    public function toggleDisplay()
    {
        $this->displayDialog = ! $this->displayDialog;
    }

    #[Session]
    public array $destinations = [];

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
        $this->destination_form->save();
        $this->destinations[] = $this->destination_form->destination;
        $this->destination_form->reset();
        $this->displayDialog = false;
    }
}
