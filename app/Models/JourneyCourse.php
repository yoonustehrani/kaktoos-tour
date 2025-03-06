<?php

namespace App\Models;

use App\Enums\TransportationType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class JourneyCourse extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'transportation_type' => TransportationType::class
        ];
    }

    public function transportation_firm(): MorphTo
    {
        return $this->morphTo();
    }

    public function departure(): MorphTo
    {
        return $this->morphTo();
    }

    public function arrival(): MorphTo
    {
        return $this->morphTo();
    }

    public function origin()
    {
        return $this->belongsTo(Location::class, 'origin_location_id');
    }

    public function destination()
    {
        return $this->belongsTo(Location::class, 'destination_location_id');
    }
}
