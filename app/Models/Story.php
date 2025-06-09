<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }
}
