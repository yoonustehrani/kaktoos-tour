<?php

namespace App\Models;

use App\Events\PricingListUpdated;
use Illuminate\Database\Eloquent\Model;

class PricingList extends Model
{
    protected $fillable = ['min_adult_price'];
    
    public function pricings()
    {
        return $this->hasMany(Pricing::class);
    }
    public function dates()
    {
        return $this->belongsToMany(TourDate::class, 'pricing_list_tour_date');
    }
    public function package()
    {
        return $this->belongsTo(TourPackage::class, 'tour_package_id');
    }
}
