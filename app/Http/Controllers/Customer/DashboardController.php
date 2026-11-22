<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Dashboard customer: menampilkan ringkasan aktivitas.
     */
    public function index(): View
    {
        $user = auth()->user();

        $totalBookings = Booking::where('user_id', $user->id)->count();
        $activeBookings = Booking::where('user_id', $user->id)
            ->whereIn('status', ['waiting_payment', 'payment_verification', 'confirmed', 'ongoing'])
            ->count();
        $completedBookings = Booking::where('user_id', $user->id)
            ->where('status', 'completed')
            ->count();

        $recentBookings = Booking::with(['car', 'payment'])
            ->where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        $activeBooking = Booking::with(['car', 'payment'])
            ->where('user_id', $user->id)
            ->whereIn('status', ['ongoing', 'confirmed'])
            ->latest()
            ->first();

        return view('customer.dashboard', compact(
            'totalBookings', 'activeBookings', 'completedBookings', 'recentBookings', 'activeBooking'
        ));
    }
}
