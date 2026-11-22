<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CarController as AdminCarController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Customer\DashboardController as CustomerDashboardController;
use App\Http\Controllers\Customer\BookingController as CustomerBookingController;
use App\Http\Controllers\Customer\PaymentController as CustomerPaymentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes (tanpa login)
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/cars', [CarController::class, 'index'])->name('cars.index');
Route::get('/cars/{car}', [CarController::class, 'show'])->name('cars.show');

// Webhook notifikasi pembayaran dari Midtrans (publik, tanpa CSRF)
Route::post('/payment/notification', [CustomerPaymentController::class, 'notificationHandler'])->name('payment.notification');

// Dashboard auth (customer)
Route::get('/dashboard', function () {
    if (auth()->user() && auth()->user()->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('customer.dashboard');
})->middleware(['auth'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| Authenticated Routes (user login, baik customer maupun admin)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Customer Routes (role: customer) - /customer/*
|--------------------------------------------------------------------------
| Middleware role:customer menjaga agar hanya customer yang dapat
| mengakses halaman ini.
*/
Route::middleware(['auth', 'role:customer'])->prefix('customer')->name('customer.')->group(function () {
    Route::get('/dashboard', [CustomerDashboardController::class, 'index'])->name('dashboard');

    Route::get('/bookings', [CustomerBookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/create/{car}', [CustomerBookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings/store/{car}', [CustomerBookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{booking}', [CustomerBookingController::class, 'show'])->name('bookings.show');
    Route::delete('/bookings/{booking}', [CustomerBookingController::class, 'destroy'])->name('bookings.destroy');

    Route::get('/bookings/{booking}/payment', [CustomerPaymentController::class, 'create'])->name('payments.create');
    Route::post('/bookings/{booking}/payment', [CustomerPaymentController::class, 'store'])->name('payments.store');
});

/*
|--------------------------------------------------------------------------
| Admin Routes (role: admin) - /admin/*
|--------------------------------------------------------------------------
| Middleware role:admin memastikan customer TIDAK dapat mengakses /admin/*.
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::resource('categories', CategoryController::class);

    Route::resource('cars', AdminCarController::class);

    Route::get('customers', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('customers/{customer}', [CustomerController::class, 'show'])->name('customers.show');

    Route::get('bookings', [AdminBookingController::class, 'index'])->name('bookings.index');
    Route::get('bookings/export', [AdminBookingController::class, 'export'])->name('bookings.export');
    Route::get('bookings/export-pdf', [AdminBookingController::class, 'exportPdf'])->name('bookings.export-pdf');
    Route::get('bookings/{booking}', [AdminBookingController::class, 'show'])->name('bookings.show');
    Route::patch('bookings/{booking}/status', [AdminBookingController::class, 'updateStatus'])->name('bookings.update-status');

    Route::get('payments', [AdminPaymentController::class, 'index'])->name('payments.index');
    Route::get('payments/export', [AdminPaymentController::class, 'export'])->name('payments.export');
    Route::get('payments/export-pdf', [AdminPaymentController::class, 'exportPdf'])->name('payments.export-pdf');
    Route::get('payments/{payment}', [AdminPaymentController::class, 'show'])->name('payments.show');
});

require __DIR__.'/auth.php';
