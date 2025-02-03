<?php

namespace App\Models;

use App\Exceptions\CountryCodeErrorException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Location extends Model
{
    /** @use HasFactory<\Database\Factories\LocationFactory> */
    use HasFactory;

    public $timestamps = false;

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_code');
    }

    public function scopeOrigin(Builder $query)
    {
        $query->whereIsOrigin(true);
    }

    public function scopeNotOrigin(Builder $query)
    {
        $query->whereIsOrigin(false);
    }

    public function toursFrom()
    {
        return $this->hasMany(Tour::class, 'origin_id')->active();
    }

    public function destinations()
    {
        return $this->hasMany(TourDestination::class);
    }

    public function tours()
    {
        return $this->belongsToMany(Tour::class, 'tour_destinations');
    }

    public function scopeFrom(Builder $query, string $countryCode)
    {
        if (! preg_match(COUNTRY_CODE_REGEX, $countryCode)) {
            throw new CountryCodeErrorException($countryCode);
        }
        $query->whereCountryCode(strtoupper($countryCode));
    }
}
