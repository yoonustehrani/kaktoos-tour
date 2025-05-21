<?php

namespace App\Livewire;

use Livewire\Component;

class Searchable extends Component
{
    public $search = '';
    public $selectedId = null;
    public $placeholder = '';
    public $selectedName = '';
    public $showDropdown = false;
    public $results = [];

    protected $listeners = ['refreshComponent' => '$refresh'];

    public function selectItem($id, $name)
    {
        $this->selectedId = $id;
        $this->selectedName = $name;
        $this->search = '';
        $this->showDropdown = false;
        $this->dispatch($this->eventName, id: $id);
        // $this->emit('itemSelected', $id);
    }

    public function empty()
    {
        $this->selectedId = null;
        $this->selectedName = '';
    }

    public function render()
    {
        return view('livewire.searchable');
    }
}
