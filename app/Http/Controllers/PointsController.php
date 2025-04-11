<?php

namespace App\Http\Controllers;

use App\Models\Points;
use Illuminate\Http\Request;

class PointsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'points' => 'required|integer|min:1',
            'action' => 'required|string|max:255',
        ]);

        $point = Points::create($validated);

        return response()->json([
            'message' => 'Points awarded successfully',
            'data' => $point
        ]);
    }

    public function total($user_id)
    {
        $total = Points::where('user_id', $user_id)->sum('points');

        return response()->json([
            'user_id' => $user_id,
            'total_points' => $total
        ]);
    }

    // Get all points history for a user
    public function history($user_id)
    {
        $points = Points::where('user_id', $user_id)->latest()->get();

        return response()->json([
            'user_id' => $user_id,
            'history' => $points
        ]);
    }
}
