<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourDestination extends Model
{
    /** @use HasFactory<\Database\Factories\TourDestinationFactory> */
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['id', 'number_of_nights', 'requires_visa', 'visa_preparation_days', 'location_id'];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
