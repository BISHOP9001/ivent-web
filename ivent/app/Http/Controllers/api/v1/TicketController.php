<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class TicketController extends Controller
{
    // Display a listing of user's tickets, optionally filtered by event ID
    public function index(Request $request)
    {
        $user_id = auth()->id();
        $event_id = $request->query('event_id');

        if ($event_id) {
            $tickets = Ticket::where('user_id', $user_id)
                ->where('event_id', $event_id)
                ->get();
        } else {
            $tickets = Ticket::where('user_id', $user_id)->get();
        }

        return response()->json($tickets);
    }

    // Create a ticket for an event participation
    public function store(Request $request)
    {
        $validated = $request->validate([
            'event_id' => 'required|exists:events,id',
            'type' => 'required|string|max:255',
        ]);

        $user_id = auth()->id();
        $event = Event::find($validated['event_id']);

        // Check if a ticket already exists for this user and event
        $existingTicket = Ticket::where('user_id', $user_id)
            ->where('event_id', $validated['event_id'])
            ->first();

        if ($existingTicket) {
            return response()->json([
                'message' => 'You already have a ticket for this event.',
                'ticket' => $existingTicket
            ], Response::HTTP_OK);
        }

        $validated['user_id'] = $user_id;
        $validated['issued_date'] = now();
        $validated['valid_until'] = $event->end_date;
        $validated['status'] = 'ready';
        $validated['unique_code'] = $this->generateUniqueCode(); // Generate and assign a unique code

        $ticket = Ticket::create($validated);
        return response()->json($ticket, Response::HTTP_CREATED);
    }

    // Generate a unique code for the ticket
    public function generateUniqueCode()
    {
        do {
            $code = Str::random(10); // Generates a random string of 10 characters
        } while (Ticket::where('unique_code', $code)->exists()); // Check uniqueness

        return $code;
    }

    // Scan a ticket and update its status to scanned
    public function scanTicket(Request $request, $ticketId)
    {
        $ticket = Ticket::findOrFail($ticketId);

        // Check if the ticket is already scanned
        if ($ticket->status === 'scanned') {
            return response()->json(['message' => 'Ticket has already been scanned.'], Response::HTTP_BAD_REQUEST);
        }

        $ticket->update(['status' => 'scanned']);

        return response()->json(['message' => 'Ticket scanned successfully.', 'ticket' => $ticket]);
    }

    // Display the specified ticket
    public function show(Ticket $ticket)
    {
        $user_id = auth()->id();

        // Check if the authenticated user owns the ticket
        if ($ticket->user_id !== $user_id) {
            return response()->json(['message' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }

        return response()->json($ticket);
    }

    // Update the specified ticket in storage
    public function update(Request $request, Ticket $ticket)
    {
        $user_id = auth()->id();

        // Check if the authenticated user owns the ticket
        if ($ticket->user_id !== $user_id) {
            return response()->json(['message' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }

        $validated = $request->validate([
            'status' => 'required|string|max:255'  // Example of updating just the status
        ]);

        $ticket->update($validated);
        return response()->json($ticket);
    }

    // Remove the specified ticket from storage
    public function destroy(Ticket $ticket)
    {
        $user_id = auth()->id();

        // Check if the authenticated user owns the ticket
        if ($ticket->user_id !== $user_id) {
            return response()->json(['message' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }

        $ticket->delete();
        return response()->json(['message' => 'Ticket deleted successfully']);
    }
}
