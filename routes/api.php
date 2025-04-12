<?php

use App\Http\Controllers\PointsController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/* Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum'); */

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

Route::get('/getallrooms', [RoomController::class, 'index']);
Route::post('/addstudent', [RoomController::class, 'addstudent']);
Route::delete('/removestudent', [RoomController::class, 'removestudent']);


Route::middleware(['auth:sanctum', 'istutor'])->group(function () {
    Route::post('/createroom', [RoomController::class, 'store']);
    Route::put('/updateroom/{room}', [RoomController::class, 'update']);
    Route::delete('/deleteroom/{room}', [RoomController::class, 'destroy']);
});

Route::get('/getallsessions', [SessionController::class, 'index']);

Route::get('/getnumberofallrooms', [RoomController::class, 'getnumberofall']);
Route::get('/getnumberofallsessions', [SessionController::class, 'getnumberofallsession']);

Route::middleware(['auth:sanctum', 'istutor'])->group(function () {
    Route::post('/createsession', [SessionController::class, 'store']);
    Route::put('/updatesession/{session}', [SessionController::class, 'update']);
    Route::delete('/deletesession/{session}', [SessionController::class, 'destroy']);
});

Route::post('/ratings', [RatingController::class, 'store']);
Route::get('/ratings/tutor/{tutor_id}/average', [RatingController::class, 'tutorAverage']);
Route::get('/ratings/tutor/{tutor_id}', [RatingController::class, 'tutorRatings']);


Route::post('/points', [PointsController::class, 'store']);
Route::get('/points/{user_id}/total', [PointsController::class, 'total']);
Route::get('/points/{user_id}/history', [PointsController::class, 'history']);
