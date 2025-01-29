<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    /** @use HasFactory<\Database\Factories\TourFactory> */
    use HasFactory, HasUlids;

    protected $fillable = ['title', 'slug', 'origin_id', 'number_of_nights'];

    public function destinations()
    {
        return $this->hasMany(TourDestination::class);
    }

    public function dates()
    {
        return $this->hasMany(TourDate::class);
    }
}
