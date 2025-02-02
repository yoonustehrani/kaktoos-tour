<?php

namespace App\Models;

use App\Enums\Currencies;
use App\Enums\TourRoomTypes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pricing extends Model
{
    /** @use HasFactory<\Database\Factories\PricingFactory> */
    use HasFactory;
    // 
    public $timestamps = false;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'currency' => Currencies::class,
            'room_type' => TourRoomTypes::class
        ];
    }

    public function scopeForAdult(Builder $query)
    {
        $query->whereIn('room_type', [TourRoomTypes::Single->value, TourRoomTypes::Double->value]);
    }

    public function scopeOnlyIRT(Builder $query)
    {
        $query->where('currency', Currencies::IRT->name);
    }
}
