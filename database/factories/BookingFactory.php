<?php

namespace Database\Factories;

use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $checkInDate = $this->faker->dateTimeBetween('next Monday', 'next Monday +7 days');

        $checkOutDate = $this->faker->dateTimeBetween($checkInDate,$checkInDate->format('Y-m-d').'+7 days' );

        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'room_id' => Room::where('status', 'available')->inRandomOrder()->first()->id,
            'check_in_date' => $checkInDate->format('Y-m-d'),
            'check_out_date' => $checkOutDate->format('Y-m-d'),
            'status' => $this->faker->randomElement(['pending', 'confirmed', 'cancelled']),
        ];
    }
}

