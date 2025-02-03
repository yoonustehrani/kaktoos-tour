<?php

namespace App\Listeners;

use App\Enums\Currencies;
use App\Events\PricingListUpdated;
use App\Models\Pricing;
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

        $display = [];
        $price_in_irt = 0;

        // get lowest price in IRT
        $min_price_irt = $pricing_list->pricings()->forAdult()->onlyIRT()->orderBy('price')->first();
        
        // $min_price_irt = $min_price_irt?->price ?? null;
        $pricings = $pricing_list->pricings()
            ->whereNotIn('currency', array_map(fn(Currencies $c) => $c->name, [Currencies::IRT, Currencies::IRR]));
        
        if ($min_price_irt?->price) {
            $pricings->where('room_type', $min_price_irt->room_type);

            $price_in_irt += $min_price_irt->price;
            array_push($display, number_format($min_price_irt->price) . " " . $min_price_irt->currency->getTitleFa());
        } else {
            $pricings->forAdult()->orderBy('price');
        }
        
        $pricings->groupBy('currency', 'id')
        ->get()
        ->each(function(Pricing $pricing) use(&$display, &$price_in_irt) {
            $price_in_irt += convert_to_toman($pricing->price, $pricing->currency);
            array_push($display, number_format($pricing->price) . " " . $pricing->currency->getTitleFa());
        });
        $pricing_list->update([
            'min_adult_price' => $price_in_irt,
            'min_adult_price_display' => implode(' + ', $display)
        ]);
    }
}
