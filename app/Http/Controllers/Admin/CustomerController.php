<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\View\View;

class CustomerController extends Controller
{
    /**
     * Menampilkan daftar semua customer.
     */
    public function index(): View
    {
        $customers = User::where('role', 'customer')
            ->withCount('bookings')
            ->latest()
            ->get();

        return view('admin.customers.index', compact('customers'));
    }

    /**
     * Menampilkan detail customer beserta riwayat booking.
     */
    public function show(User $customer): View
    {
        $customer->load(['bookings.car', 'bookings.payment']);
        return view('admin.customers.show', compact('customer'));
    }
}
