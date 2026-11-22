<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CarController extends Controller
{
    /**
     * Menampilkan daftar mobil dengan pencarian dan filter.
     */
    public function index(Request $request): View
    {
        $query = Car::with('category');

        // Pencarian berdasarkan nama / merk / model
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%")
                  ->orWhere('model', 'like', "%{$search}%");
            });
        }

        // Filter kategori
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Filter transmisi
        if ($request->filled('transmission')) {
            $query->where('transmission', $request->transmission);
        }

        // Filter harga maksimal
        if ($request->filled('max_price')) {
            $query->where('price_per_day', '<=', $request->max_price);
        }

        $cars = $query->orderBy('created_at', 'desc')->paginate(9)->withQueryString();

        $categories = Category::orderBy('name')->get();
        $transmissions = Car::select('transmission')->distinct()->pluck('transmission');

        return view('cars.index', compact('cars', 'categories', 'transmissions'));
    }

    /**
     * Menampilkan detail satu mobil.
     */
    public function show(Car $car): View
    {
        $car->load('category');
        return view('cars.show', compact('car'));
    }
}
