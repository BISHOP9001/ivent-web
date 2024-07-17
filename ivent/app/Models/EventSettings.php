<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventSettings extends Model
{
    use HasFactory;

    protected $fillable = ['event_id', 'setting_name', 'setting_value'];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
    public function formFieldTemplate()
    {
        return $this->hasOne(FormFieldTemplate::class);
    }
}
