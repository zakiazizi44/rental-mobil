<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Payment;
use App\Models\User;
use App\Models\Car;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Membuat beberapa data booking demo dengan berbagai status,
     * agar dashboard memiliki statistik dan chart dapat menampilkan data.
     */
    public function run(): void
    {
        $customer1 = User::where('email', 'customer1@example.com')->first();
        $customer2 = User::where('email', 'customer2@example.com')->first();

        $avanza = Car::where('license_plate', 'B 5678 QWE')->first();
        $civic  = Car::where('license_plate', 'B 1234 KLZ')->first();
        $crv    = Car::where('license_plate', 'B 9012 ASD')->first();
        $camry  = Car::where('license_plate', 'B 3456 FGH')->first();

        $bookings = [
            [
                'user'         => $customer1,
                'car'          => $avanza,
                'start_date'   => Carbon::now()->subDays(25),
                'end_date'     => Carbon::now()->subDays(22),
                'status'       => 'completed',
                'payment'      => 'verified',
            ],
            [
                'user'         => $customer1,
                'car'          => $civic,
                'start_date'   => Carbon::now()->subDays(18),
                'end_date'     => Carbon::now()->subDays(16),
                'status'       => 'completed',
                'payment'      => 'verified',
            ],
            [
                'user'         => $customer2,
                'car'          => $crv,
                'start_date'   => Carbon::now()->subDays(10),
                'end_date'     => Carbon::now()->subDays(8),
                'status'       => 'completed',
                'payment'      => 'verified',
            ],
            [
                'user'         => $customer2,
                'car'          => $camry,
                'start_date'   => Carbon::now()->subDays(5),
                'end_date'     => Carbon::now()->subDays(3),
                'status'       => 'completed',
                'payment'      => 'verified',
            ],
            [
                'user'         => $customer1,
                'car'          => $avanza,
                'start_date'   => Carbon::now()->subDays(2),
                'end_date'     => Carbon::now()->addDays(3),
                'status'       => 'waiting_payment',
                'payment'      => 'pending',
            ],
            [
                'user'         => $customer2,
                'car'          => $civic,
                'start_date'   => Carbon::now()->addDays(2),
                'end_date'     => Carbon::now()->addDays(5),
                'status'       => 'payment_verification',
                'payment'      => 'pending',
            ],
        ];

        foreach ($bookings as $data) {
            $car     = $data['car'];
            $start   = $data['start_date'];
            $end     = $data['end_date'];
            $totalDays = (int) round($start->diffInDays($end)) + 1;
            $pricePerDay = (int) round((float) $car->price_per_day);
            $totalPrice = $pricePerDay * $totalDays;

            $booking = Booking::create([
                'booking_code'   => 'BK-' . $start->format('Ymd') . '-' . strtoupper(Str::random(6)),
                'user_id'        => $data['user']->id,
                'car_id'         => $car->id,
                'start_date'     => $start,
                'end_date'       => $end,
                'total_days'     => $totalDays,
                'price_per_day'  => $pricePerDay,
                'total_price'    => $totalPrice,
                'status'         => $data['status'],
            ]);

            $paymentStatus = $data['payment'];

            Payment::create([
                'booking_id'      => $booking->id,
                'payment_method'  => 'Transfer Bank BCA',
                'amount'          => $totalPrice,
                'payment_proof'   => null,
                'status'          => $paymentStatus,
                'paid_at'         => $paymentStatus !== 'pending' ? Carbon::now()->subDays(30) : null,
                'verified_at'     => $paymentStatus === 'verified' ? Carbon::now()->subDays(29) : null,
            ]);
        }
    }
}
