<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormFieldTemplateValue extends Model
{
    use HasFactory;

    protected $fillable = ['form_field_template_id', 'value'];

    public function formFieldTemplate()
    {
        return $this->belongsTo(FormFieldTemplate::class);
    }
}
