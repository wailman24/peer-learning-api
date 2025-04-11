<?php

namespace App\Http\Controllers;

use App\Http\Resources\SessionResource;
use App\Models\Session;
use Illuminate\Http\Request;

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
            $request->validate([
                'room_id' => 'required|exists:rooms,id',
                'title' => 'required',
                'start_time' => 'required',
                'meet_link' => 'required'
            ]);
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

            $updatedsession = $session->update([
                'room_id' => $request->room_id,
                'title' => $request->title,
                'start_time' => $request->start_time,
                'meet_link' => $request->meet_link
            ]);
            return new SessionResource($updatedsession);
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
