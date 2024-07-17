<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements HasMedia
{
    use HasApiTokens, HasFactory, InteractsWithMedia, HasRoles;

    protected $fillable = ['name', 'email', 'password', 'profile_info'];

    public function events()
    {
        return $this->hasMany(Event::class, 'created_by_user_id');
    }

    public function participation()
    {
        return $this->belongsToMany(Event::class, 'participation');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function participations()
    {
        return $this->hasMany(Participation::class);
    }
}
