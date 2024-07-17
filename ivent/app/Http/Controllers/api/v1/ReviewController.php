<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Review;

class ReviewController extends Controller
{
    // Display a listing of the user's review records, optionally filtered by event ID
    public function index(Request $request)
    {
        $user_id = auth()->id();
        $event_id = $request->query('event_id');

        if ($event_id) {
            $feedbacks = Review::with(['user', 'event'])
                ->where('user_id', $user_id)
                ->where('event_id', $event_id)
                ->get();
        } else {
            $feedbacks = Review::with(['user', 'event'])
                ->where('user_id', $user_id)
                ->get();
        }

        return response()->json($feedbacks);
    }

    // Store a newly created review in storage
    public function store(Request $request)
    {
        $validated = $request->validate([
            'event_id' => 'required|exists:events,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        $user_id = auth()->id();
        $validated['user_id'] = $user_id;

        $review = Review::create($validated);

        return response()->json($review, 201);
    }

    // Display the specified review
    public function show(Review $review)
    {
        $user_id = auth()->id();

        // Check if the authenticated user owns the review
        if ($review->user_id !== $user_id) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return response()->json($review->load(['user', 'event']));
    }

    // Update the specified review in storage
    public function update(Request $request, Review $review)
    {
        $user_id = auth()->id();

        // Check if the authenticated user owns the review
        if ($review->user_id !== $user_id) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        $review->update($validated);
        return response()->json($review);
    }

    // Remove the specified review from storage
    public function destroy(Review $review)
    {
        $user_id = auth()->id();

        // Check if the authenticated user owns the review
        if ($review->user_id !== $user_id) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $review->delete();
        return response()->json(['message' => 'Review deleted successfully']);
    }
}
