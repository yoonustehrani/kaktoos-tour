<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PricingList extends Model
{
    public function pricings()
    {
        $this->hasMany(Pricing::class);
    }
    public function dates()
    {
        $this->belongsToMany(TourDate::class, 'pricing_list_tour_date');
    }
}
