<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormFieldTemplate extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'field_type', 'default_value', 'required'];
    protected $casts = [
        'default_value' => 'array',
    ];
    public function formFieldTemplateValues()
    {
        return $this->hasMany(FormFieldTemplateValue::class);
    }
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
