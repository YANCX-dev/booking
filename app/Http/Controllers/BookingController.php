<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\User;
use http\Env\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $bookings = Booking::with('user', 'room')->get();
        return response()->json($bookings);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'room_id' => 'required|exists:rooms,id',
            'check_in_date' => 'required|date',
            'check_out_date' => 'required|date',
            'status' => 'required|in:pending,confirmed,cancelled',
        ]);

        $booking = Booking::create([
            'user_id' => $request->user_id,
            'room_id' => $request->room_id,
            'check_in_date' => $request->check_in_date,
            'check_out_date' => $request->check_out_date,
            'status' => $request->status,
        ]);

        return response()->json($booking, 201);

    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $booking = Booking::with('user', 'room')->find($id);

        if (!$booking) {
            return response()->json(null, 404);
        }

        return response()->json($booking);

    }

    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function update(Request $request, $id): JsonResponse
    {
        $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'room_id' => 'required|exists:rooms,id',
            'check_in_date' => 'required|date',
            'check_out_date' => 'required|date',
            'status' => 'required|in:pending,confirmed,cancelled',
        ]);

        $booking = Booking::find($id);

        if (!$booking) {
            return response()->json(['message' => "Booking not found"], 404);
        }

        $booking->update($request->all());

        return response()->json($booking, 200);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $booking = Booking::find($id);

        if (!$booking) {
            return response()->json(['message' => 'Booking not found'], 404);
        }

        $booking->delete();
        return response()->json(['message' => 'Booking deleted successfully.'], 200);
    }

    /**
     * @param $userId
     * @return JsonResponse
     */
    public function userBooking($userId): JsonResponse
    {
        $user = User::find($userId);

        if (!$user) {
            return response()->json(['message' => "User not found"], 404);
        }

        $bookings = $user->bookings()->with('room')->get();
        return response()->json($bookings);


    }

    public function test(): JsonResponse
    {
        return response()->json([
            'test'=>'test',
        ]);
    }
}
