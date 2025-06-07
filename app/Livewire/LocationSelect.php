<?php

namespace App\Livewire;

use App\Models\Location;

class LocationSelect extends Searchable
{
    public $eventName;
    public $itemComponent;
    public $originMode = false;
    public $pro = false;

    public function getDefaultQuery()
    {
        return $this->originMode ? Location::origin() : Location::notOrigin();
    }

    public function mount($selectedId = null)
    {
        $this->itemComponent = "location-select-item" . ($this->pro ? '-pro' : '');
        $this->results = $this->getDefaultQuery()->limit(5)->get();
        if ($selectedId) {
            $model = $this->getDefaultQuery()->find($selectedId);
            if ($model) {
                $this->selectedId = $model->id;
                $this->selectedName = $model->name_fa ?? $model->name;
            }
        }
    }

    public function updatedSearch()
    {
        if (strlen($this->search) > 1) {
            $this->results = $this->getDefaultQuery()
                ->where(function($q) {
                    $q->where('name', 'ILIKE', '%' . $this->search . '%')
                        ->orWhere('name_fa', 'like', '%' . $this->search . '%');
                })
                ->orWhereHas('country', function($q) {
                    $q->where('name', 'ILIKE', '%' . $this->search . '%')
                        ->orWhere('name_fa', 'like', '%' . $this->search . '%');
                })
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