<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourPackage extends Model
{
    /** @use HasFactory<\Database\Factories\TourPackageFactory> */
    use HasFactory;

    public $timestamps = false;


    public function hotels()
    {
        return $this->belongsToMany(Hotel::class, 'hotel_package')->withPivot(['service', 'room_style', 'details']);
    }

    public function pricing_list()
    {
        return $this->hasOne(PricingList::class);
    }
}
