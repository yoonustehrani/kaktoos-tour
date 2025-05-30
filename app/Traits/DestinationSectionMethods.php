<?php

namespace App\Traits;

use App\Livewire\Forms\DestinationForm;
use App\Models\Location;
use App\Models\TourDestination;
use Illuminate\Support\Collection;
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

    public Collection $destinations;

    #[On('destination-item-selected')]
    public function setLocationId($id) {
        $this->destination_form->location_id = intval($id);
    }

    public function removeDestination($id) {
        try {
            TourDestination::whereId($id)->delete();
            $this->destinations = $this->destinations->filter(fn($x) => $x['id'] !== intval($id));
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
