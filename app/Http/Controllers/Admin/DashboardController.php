<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Car;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Dashboard admin: menampilkan statistik dan booking terbaru.
     */
    public function index(): View
    {
        $totalCars        = Car::count();
        $availableCars    = Car::where('status', 'available')->count();
        $rentedCars       = Car::where('status', 'rented')->count();
        $totalCustomers   = User::where('role', 'customer')->count();
        $totalBookings    = Booking::count();
        $waitingPaymentBookings = Booking::where('status', 'waiting_payment')->count();
        $confirmedBookings = Booking::where('status', 'confirmed')->count();
        $completedBookings = Booking::whereIn('status', ['completed'])->count();
        $totalRevenue     = Booking::where('status', 'completed')->sum('total_price');

        $recentBookings = Booking::with(['user', 'car'])
            ->latest()
            ->take(8)
            ->get();

        return view('admin.dashboard', compact(
            'totalCars', 'availableCars', 'rentedCars', 'totalCustomers',
            'totalBookings', 'waitingPaymentBookings', 'confirmedBookings', 'completedBookings', 'totalRevenue',
            'recentBookings'
        ));
    }
}
