<?php

namespace App\Http\Controllers;

use App\Http\Resources\SessionResource;
use App\Models\Room;
use App\Models\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return SessionResource::collection(Session::all());
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $user = Auth::user();
            $request->validate([
                'room_id' => 'required|exists:rooms,id',
                'title' => 'required',
                'start_time' => 'required',
                'meet_link' => 'required'
            ]);
            $room = Room::findOrFail($request->room_id);
            if ($room->tutor_id != $user->id) {
                return response()->json([
                    'message' => 'this room is not for this user'
                ]);
            }
            $session = Session::create([
                'room_id' => $request->room_id,
                'title' => $request->title,
                'start_time' => $request->start_time,
                'meet_link' => $request->meet_link
            ]);
            return new SessionResource($session);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function getnumberofallsession()
    {
        $numberpfsessions = Session::count();
        return response()->json($numberpfsessions);
    }
    /**
     * Display the specified resource.
     */
    public function show(Session $session)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Session $session)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Session $session)
    {
        try {
            $request->validate([
                'room_id' => 'required|exists:rooms,id',
                'title' => 'required',
                'start_time' => 'required',
                'meet_link' => 'required'
            ]);

            $session->update([
                'room_id' => $request->room_id,
                'title' => $request->title,
                'start_time' => $request->start_time,
                'meet_link' => $request->meet_link
            ]);
            return new SessionResource($session);
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
    public function destroy(Session $session)
    {
        try {
            $session->delete();
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
