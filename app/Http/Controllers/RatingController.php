<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{

    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'student_id' => 'required|exists:users,id',
            'tutor_id' => 'required|exists:users,id',
            'rating' => 'required|integer|min:1|max:5'
        ]);

        $rating = Rating::create($validated);

        return response()->json([
            'status' => true,
            'message' => 'Rating submitted successfully',
            'data' => $rating
        ]);
    }

    public function tutorAverage($tutor_id)
    {
        $avg = Rating::where('tutor_id', $tutor_id)->avg('rating');

        return response()->json([
            'tutor_id' => $tutor_id,
            'average_rating' => round($avg, 2)
        ]);
    }

    public function tutorRatings($tutor_id)
    {
        $ratings = Rating::where('tutor_id', $tutor_id)->with(['student', 'room'])->get();

        return response()->json([
            'tutor_id' => $tutor_id,
            'ratings' => $ratings
        ]);
    }
}
