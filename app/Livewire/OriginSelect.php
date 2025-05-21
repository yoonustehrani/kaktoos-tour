<?php

namespace App\Livewire;

use App\Models\Location;

class OriginSelect extends Searchable
{
    protected $eventName = 'origin-item-selected';
    public $itemComponent = 'origin-select-item';

    public function mount($selectedId = null)
    {
        $this->results = Location::origin()->limit(5)->get();
        if ($selectedId) {
            $model = Location::origin()->find($selectedId);
            if ($model) {
                $this->selectedId = $model->id;
                $this->selectedName = $model->name_fa ?? $model->name;
            }
        }
    }

    public function updatedSearch()
    {
        if (strlen($this->search) > 1) {
            $this->results = Location::origin()
                ->where(function($q) {
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