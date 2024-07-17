<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = ['participation_id', 'checked_in', 'check_in_time', 'check_out_time'];

    public function participation()
    {
        return $this->belongsTo(Participation::class);
    }
}
