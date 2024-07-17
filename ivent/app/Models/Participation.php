<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Participation extends Model
{
    protected $fillable = ['user_id', 'event_id', 'activities', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

    public function attendance()
    {
        return $this->hasOne(Attendance::class);
    }
}
