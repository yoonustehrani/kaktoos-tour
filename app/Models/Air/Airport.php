<?php

namespace App\Models\Air;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Airport extends Model
{
    protected $connection = 'air-hotel';

    public function country()
    {
        return $this->belongsTo(\App\Models\Country::class, 'country_code');
    }

    public function scopeOnlyNational(Builder $query)
    {
        $query->where('is_international', false);
    }
    public function scopeOnlyInternational(Builder $query)
    {
        $query->where('is_international', true);
    }
    public function scopeOnlyIran(Builder $query)
    {
        $query->where('country_code', 'IR');
    }
}
