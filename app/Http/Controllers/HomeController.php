<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Car;
use App\Models\Category;
use App\Models\User;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Tampilkan halaman utama (Home).
     * Menampilkan mobil unggulan, statistik, dan data pendukung lainnya.
     */
    public function index(): View
    {
        $featuredCars = Car::with('category')
            ->where('status', 'available')
            ->latest()
            ->take(6)
            ->get();

        // Ringkasan statistik (hanya baca, tidak mengubah data).
        $stats = [
            'cars'      => Car::where('status', 'available')->count(),
            'customers' => User::where('role', 'customer')->count(),
            'bookings'  => Booking::where('status', '!=', 'cancelled')->count(),
        ];

        // Kategori untuk filter pada quick booking di halaman utama.
        $categories = Category::orderBy('name')->get();

        return view('home', compact('featuredCars', 'stats', 'categories'));
    }
}
