<?php

namespace App\Listeners;

use App\Events\PricingListUpdated;
use Illuminate\Queue\InteractsWithQueue;

class UpdatePricingListMinAdultPrice
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(PricingListUpdated $event): void
    {
        $pricing_list = $event->pricingList;

        // get lowest price in IRT
        $min_price = $pricing_list->pricings()->forAdult()->onlyIRT()->orderBy('price')->first()?->price ?? null;
        $pricing_list->update([
            'min_adult_price' => $min_price
        ]);
    }
}
