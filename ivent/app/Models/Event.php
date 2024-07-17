<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'title', 'description', 'start_date', 'end_date', 'location_id',
        'category_id', 'created_by_user_id', 'event_type', 'payment_required'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    public function eventSettings()
    {
        return $this->hasMany(EventSettings::class);
    }

    public function participations()
    {
        return $this->hasMany(Participation::class);
    }

    public function participants()
    {
        return $this->belongsToMany(User::class, 'participation');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
