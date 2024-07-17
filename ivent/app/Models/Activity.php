<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = ['event_id', 'name', 'description', 'start_time', 'end_time'];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
