<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\EventSettings;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class EventSettingsController extends Controller
{
    // Get settings for a specific event
    public function getSettings($eventId)
    {
        $settings = EventSettings::where('event_id', $eventId)->get();
        return response()->json($settings);
    }
}
