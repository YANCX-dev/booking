<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\BookingController;


Route::get('/test', function () {
    return response()->json(['message' => 'Hello, API!']);
});

Route::post('users/{id}/bookings', [BookingController::class, 'getBookingsByUser']);
//JWT AUTH
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout']);
Route::get('me', [AuthController::class, 'me']);

Route::get('/bookings', [BookingController::class, 'index']);
Route::post('/bookings', [BookingController::class, 'create']);
Route::get('/bookings/{$id}', [BookingController::class, 'show']);
Route::put('/bookings/{$id}', [BookingController::class, 'update']);
Route::delete('/bookings/{$id}', [BookingController::class, 'destroy']);
Route::get('user/{$userId}/bookings', [BookingController::class, 'userBooking']);
