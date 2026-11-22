<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class CarController extends Controller
{
    /**
     * Menampilkan daftar semua mobil.
     */
    public function index(): View
    {
        $cars = Car::with('category')->latest()->get();
        return view('admin.cars.index', compact('cars'));
    }

    /**
     * Redirection dari route show (tidak dipakai dalam UI).
     */
    public function show(Car $car): \Illuminate\Http\RedirectResponse
    {
        return redirect()->route('admin.cars.edit', $car);
    }

    /**
     * Form tambah mobil.
     */
    public function create(): View
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.cars.create', compact('categories'));
    }

    /**
     * Simpan mobil baru dengan upload gambar.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'category_id'    => ['required', 'exists:categories,id'],
            'name'           => ['required', 'string', 'max:255'],
            'brand'          => ['required', 'string', 'max:255'],
            'model'          => ['required', 'string', 'max:255'],
            'year'           => ['required', 'integer', 'min:1990', 'max:' . date('Y') + 1],
            'license_plate'  => ['required', 'string', 'max:20', 'unique:cars,license_plate'],
            'price_per_day'  => ['required', 'numeric', 'min:0'],
            'capacity'       => ['required', 'integer', 'min:1'],
            'transmission'   => ['required', 'string'],
            'fuel_type'      => ['required', 'string'],
            'color'          => ['nullable', 'string', 'max:50'],
            'description'    => ['nullable', 'string'],
            'facilities'     => ['nullable', 'string'],
            'status'         => ['required', 'in:available,rented,maintenance'],
            'image'          => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        // Upload gambar mobil (opsional, fallback ke placeholder)
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('cars', 'public');
        }

        Car::create($data);

        return redirect()->route('admin.cars.index')
            ->with('success', 'Mobil berhasil ditambahkan.');
    }

    /**
     * Form edit mobil.
     */
    public function edit(Car $car): View
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.cars.edit', compact('car', 'categories'));
    }

    /**
     * Update data mobil.
     */
    public function update(Request $request, Car $car): RedirectResponse
    {
        $data = $request->validate([
            'category_id'    => ['required', 'exists:categories,id'],
            'name'           => ['required', 'string', 'max:255'],
            'brand'          => ['required', 'string', 'max:255'],
            'model'          => ['required', 'string', 'max:255'],
            'year'           => ['required', 'integer', 'min:1990', 'max:' . date('Y') + 1],
            'license_plate'  => ['required', 'string', 'max:20', 'unique:cars,license_plate,' . $car->id],
            'price_per_day'  => ['required', 'numeric', 'min:0'],
            'capacity'       => ['required', 'integer', 'min:1'],
            'transmission'   => ['required', 'string'],
            'fuel_type'      => ['required', 'string'],
            'color'          => ['nullable', 'string', 'max:50'],
            'description'    => ['nullable', 'string'],
            'facilities'     => ['nullable', 'string'],
            'status'         => ['required', 'in:available,rented,maintenance'],
            'image'          => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        // Handle penggantian gambar lama
        if ($request->hasFile('image')) {
            if ($car->image) {
                Storage::disk('public')->delete($car->image);
            }
            $data['image'] = $request->file('image')->store('cars', 'public');
        }

        $car->update($data);

        return redirect()->route('admin.cars.index')
            ->with('success', 'Mobil berhasil diperbarui.');
    }

    /**
     * Hapus mobil sekaligus gambar terkait.
     */
    public function destroy(Car $car): RedirectResponse
    {
        if ($car->image) {
            Storage::disk('public')->delete($car->image);
        }

        $car->delete();

        return redirect()->route('admin.cars.index')
            ->with('success', 'Mobil berhasil dihapus.');
    }
}
