<?php

use App\Http\Controllers\RoomController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/* Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum'); */

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

Route::get('/getallrooms', [RoomController::class, 'index']);
Route::post('/createroom', [RoomController::class, 'store']); //have to be in middlware
Route::post('/addstudent', [RoomController::class, 'addstudent']);
Route::delete('/removestudent', [RoomController::class, 'removestudent']);
Route::put('/updateroom/{room}', [RoomController::class, 'update']); //have to be in middlware
Route::delete('/deleteroom', [RoomController::class, 'destroy']); //have to be in middlware

