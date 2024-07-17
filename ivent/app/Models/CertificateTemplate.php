<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CertificateTemplate extends Model
{
    protected $fillable = ['settings_id', 'background_image_url', 'layout_details'];

    public function eventSettings()
    {
        return $this->belongsTo(EventSettings::class);
    }
}
