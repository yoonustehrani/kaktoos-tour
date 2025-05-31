<?php

namespace App\Livewire;

use App\Models\Airline;

class AirlineSelect extends Searchable
{
    protected $eventName = 'airline-item-selected';
    public $itemComponent = 'airline-select-item';

    public function mount($selectedId = null)
    {
        $this->results = Airline::whereNotNull('name_fa')->where('name_fa', '<>', '')->limit(5)->get()->toArray();
        if ($selectedId) {
            $model = Airline::find($selectedId);
            if ($model) {
                $this->selectedId = $model->code;
                $this->selectedName = $model->name_fa ?? $model->name;
            }
        }
    }

    public function updatedSearch()
    {
        if (strlen($this->search) > 1) {
            $this->results = Airline::query()
                ->where('name', 'ILIKE', '%' . $this->search . '%')
                ->orWhere('name_fa', 'like', '%' . $this->search . '%')
                ->orWhere('code', 'ILIKE', '%' . $this->search . '%')
                ->limit(10)
                ->get()
                ->toArray();
            $this->showDropdown = true;
        } else {
            $this->results = [];
            $this->showDropdown = false;
        }
    }
}