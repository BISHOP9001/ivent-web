<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = ['address', 'city', 'country', 'coordinates'];

    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
