<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Participation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventSettings;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Auth;

class ParticipationController extends Controller
{
    // Display a listing of the user's participation records, optionally filtered by event ID
    public function index(Request $request)
    {
        $user_id = auth()->id();
        $event_id = $request->query('event_id');

        if ($event_id) {
            $participations = Participation::with(['user', 'event'])
                ->where('user_id', $user_id)
                ->where('event_id', $event_id)
                ->get();
        } else {
            $participations = Participation::with(['user', 'event'])
                ->where('user_id', $user_id)
                ->get();
        }

        return response()->json($participations);
    }

    // Store a newly created participation in storage
    public function store(Request $request)
    {
        // Validate the request except for user_id
        $validated = $request->validate([
            'event_id' => 'required|exists:events,id',
            'status' => 'string|nullable',
            'activities' => 'required|string' // Can be a list of activity IDs or '*'
        ]);

        $user_id = auth()->id();

        // Check if the user has already registered for this event
        $existingParticipation = Participation::where('user_id', $user_id)
            ->where('event_id', $validated['event_id'])
            ->first();

        if ($existingParticipation) {
            return response()->json(['message' => 'You have already registered for this event.'], 409);
        }

        $validated['user_id'] = $user_id;

        // Handle the activities list
        if (isset($validated['activities'])) {
            if ($validated['activities'] === '*') {
                // Register for all activities within the event
                $activityIds = Event::find($validated['event_id'])->activities()->pluck('id');
                $validated['activities'] = $activityIds->join(',');
            } // else it's assumed to be a comma-separated list of activity IDs
        }

        $participation = Participation::create($validated);

        return response()->json($participation, 200);
    }

    // Display the specified participation
    public function show(Participation $participation)
    {
        $user_id = auth()->id();

        // Check if the authenticated user owns the participation
        if ($participation->user_id !== $user_id) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return response()->json($participation->load(['user', 'event']));
    }

    // Update the specified participation in storage
    public function update(Request $request, Participation $participation)
    {
        $user_id = auth()->id();

        // Check if the authenticated user owns the participation
        if ($participation->user_id !== $user_id) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $validated = $request->validate([
            'status' => 'required|string|max:255'
        ]);

        $participation->update($validated);
        return response()->json($participation);
    }

    // Remove the specified participation from storage
    public function destroy(Participation $participation)
    {
        $user_id = auth()->id();

        // Check if the authenticated user owns the participation
        if ($participation->user_id !== $user_id) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $participation->delete();
        return response()->json(['message' => 'Participation cancelled successfully']);
    }

    public function checkParticipation($eventId)
    {
        $user = Auth::user();
        $event = Event::with('participations')->find($eventId);

        if (!$event) {
            return response()->json(['message' => 'Event not found'], 404);
        }

        $isParticipant = $event->participations()->where('user_id', $user->id)->exists();


        return response()->json(['isParticipant' => $isParticipant]);
    }
    public function participateWithAccessCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'access_code' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = Auth::user();
        $accessCode = $request->input('access_code');

        $eventSetting = EventSettings::with('event')->where('setting_name', '=', 'access_code')
            ->where('setting_value', $accessCode)
            ->first();
        if (!$eventSetting) {
            return response()->json(['message' => 'Invalid access code'], 404);
        }

        $event = $eventSetting->event;

        // Check if the user is already participating
        if ($event->participations()->where('user_id', $user->id)->exists()) {
            return response()->json(['message' => 'User is already participating in this event'], 409);
        }
        $validated = [
            'event_id' => $event->id,
            'status' => 'registred',
            'activities' => '*',
            'user_id' => $user->id
        ];
        // Create a participation record
        if (isset($validated['activities'])) {
            if ($validated['activities'] === '*') {
                // Register for all activities within the event
                $activityIds = Event::find($validated['event_id'])->activities()->pluck('id');
                $validated['activities'] = $activityIds->join(',');
            } // else it's assumed to be a comma-separated list of activity IDs
        }

        $participation = Participation::create($validated);
        return response()->json($participation, 200);
    }
}
