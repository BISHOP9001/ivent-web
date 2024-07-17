<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    /**
     * Display a listing of the events.
     */
    public function index()
    {
        $events = Event::with('location', 'user', 'eventSettings')->get();
        return response()->json($events);
    }

    /**
     * Store a newly created event in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'location_id' => 'required|integer',
            'category_id' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $event = Event::create($request->all());
        $eventSetting = EventSettings::create(
            [
                "setting_name" => "max_participants",
                "event_id" => $event->id
            ],
        );
        $eventSetting = EventSettings::create(
            [
                "setting_name" => "location",
                "event_id" => $event->id

            ],
        );
        $eventSetting = EventSettings::create(
            [
                "setting_name" => "access_code",
                "event_id" => $event->id

            ],
        );


        return response()->json($event, 201);
    }

    /**
     * Display the specified event.
     */
    public function show($id)
    {
        $event = Event::with('location', 'user', 'eventSettings')->find($id);
        if (!$event) {
            return response()->json(['message' => 'Event not found'], 404);
        }
        return response()->json($event);
    }

    /**
     * Update the specified event in storage.
     */
    public function update(Request $request, $id)
    {
        $event = Event::find($id);
        if (!$event) {
            return response()->json(['message' => 'Event not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'string|max:255',
            'description' => 'string',
            'start_date' => 'date',
            'end_date' => 'date',
            'location_id' => 'integer',
            'category_id' => 'integer'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $event->update($request->all());
        return response()->json($event);
    }

    /**
     * Remove the specified event from storage.
     */
    public function destroy($id)
    {
        $event = Event::find($id);
        if (!$event) {
            return response()->json(['message' => 'Event not found'], 404);
        }

        $event->delete();
        return response()->json(['message' => 'Event deleted successfully']);
    }
    public function getEventsByCategoryId($categoryId)
    {
        $events = Event::with('location')->where('category_id', $categoryId)->get();
        return response()->json($events);
    }

    public function getParticipatingEvents()
    {
        $user = Auth::user();
        $events = Event::with('eventSettings', 'user')->whereHas('participations', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->with('location')->get();
        return response()->json($events);
    }
}
