<?php

namespace App\Models\Air;

use Illuminate\Database\Eloquent\Model;

class Airport extends Model
{
    protected $connection = 'air-hotel';

    public function country()
    {
        return $this->belongsTo(\App\Models\Country::class, 'country_code');
    }
}
