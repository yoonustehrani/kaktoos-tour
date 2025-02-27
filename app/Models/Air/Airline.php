<?php

namespace App\Models\Air;

use Illuminate\Database\Eloquent\Model;

class Airline extends Model
{
    protected $connection = 'air-hotel';
    
    public $primaryKey = 'code';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = ['code', 'icao', 'logo', 'name', 'name_fa'];
}
