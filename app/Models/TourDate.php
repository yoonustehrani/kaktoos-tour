<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourDate extends Model
{
    use HasFactory;
    
    public $timestamps = false;

    public function pricing_lists()
    {
        return $this->belongsToMany(PricingList::class, 'pricing_list_tour_date');
    }

    public function scopeOnlyUpcoming(Builder $query)
    {
        $query->where('start_date', '>=', now()->format('Y-m-d'));
    }
}
