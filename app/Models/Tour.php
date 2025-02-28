<?php

namespace App\Models;

use App\Enums\TourPaymentType;
use App\Models\Air\Airline;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    /** @use HasFactory<\Database\Factories\TourFactory> */
    use HasFactory, HasUlids;

    protected $fillable = ['title', 'slug', 'origin_id', 'number_of_nights'];

    protected function casts(): array
    {
        return [
            'payment_type' => TourPaymentType::class
        ];
    }

    public function destinations()
    {
        return $this->hasMany(TourDestination::class);
    }

    public function origin()
    {
        return $this->belongsTo(Location::class);
    }

    public function dates()
    {
        return $this->hasMany(TourDate::class);
    }

    public function pricing_lists()
    {
        return $this->hasMany(PricingList::class);
    }

    public function packages()
    {
        return $this->hasMany(TourPackage::class);
    }

    public function airline()
    {
        return $this->belongsTo(Airline::class, 'airline_code');
    }

    public function scopeActive(Builder $query)
    {
        $query->whereActive(true);
    }
}
