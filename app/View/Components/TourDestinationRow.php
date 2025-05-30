<?php

namespace App\View\Components;

use App\Models\TourDestination;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TourDestinationRow extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public $destination)
    {
        $this->destination = $destination;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.tour-destination-row');
    }
}
