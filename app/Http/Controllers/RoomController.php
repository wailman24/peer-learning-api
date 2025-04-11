<?php

namespace App\Http\Controllers;

use App\Http\Resources\RoomResource;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return RoomResource::collection(Room::all());
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required',
                'description' => 'required',
                'tutor_id' => 'required|exists:users,id'
            ]);

            $room = Room::create([
                'title' => $request->title,
                'description' => $request->description,
                'tutor_id' => $request->tutor_id
            ]);
            return new RoomResource($room);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function addstudent(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:users,id',
            'room_id' => 'required|exists:rooms,id'
        ]);

        $studentId = $validated['student_id'];
        $room = $validated['room_id'];
        // Check if student already joined
        if ($room->students()->where('user_id', $studentId)->exists()) {
            return response()->json(['message' => 'Student already joined this room.'], 409);
        }

        $room->students()->attach($studentId);

        return response()->json(['message' => 'Student successfully added to the room.']);
    }

    public function removestudent(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:users,id',
            'room_id' => 'required|exists:rooms,id'
        ]);

        $studentId = $validated['student_id'];
        $room = $validated['room_id'];
        $room->students()->detach($studentId);

        return response()->json(['message' => 'Student removed from room.']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Room $room)
    {
        try {
            $request->validate([
                'title' => 'required',
                'description' => 'required',
                'tutor_id' => 'required|exists:users,id'
            ]);

            $updatedroom = $room->update([
                'title' => $request->title,
                'description' => $request->description,
                'tutor_id' => $request->tutor_id
            ]);
            return new RoomResource($updatedroom);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room)
    {
        try {
            $room->delete();
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
