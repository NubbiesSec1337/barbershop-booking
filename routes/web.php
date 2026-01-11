<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookingController;

// LANDING PAGE (Public) - WITH DATA
Route::get('/', function () {
    $services = \App\Models\Service::where('is_active', true)
        ->orderBy('price')
        ->get();
    
    $barbers = \App\Models\Barber::where('is_available', true)
        ->take(6)
        ->get();
    
    $stats = [
        'barbers' => \App\Models\Barber::count(),
        'bookings' => \App\Models\Booking::count(),
        'customers' => \App\Models\User::where('role', 'customer')->count(),
    ];
    
    return view('welcome', compact('services', 'barbers', 'stats'));
})->name('home');

// AUTH ROUTES (Breeze)
Route::get('/dashboard', function () {
    return redirect()->route('bookings.index');
})->middleware('auth')->name('dashboard');

require __DIR__.'/auth.php';

// BOOKING ROUTES - CUSTOMER (PROTECTED)
Route::middleware('auth')->group(function () {
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/my', [BookingController::class, 'my'])->name('bookings.my');
    Route::get('/bookings/history', [BookingController::class, 'my'])->name('bookings.history'); // Alias
    Route::post('/bookings/{barber}/favourite', [BookingController::class, 'toggleFavourite'])->name('bookings.favourite');
    Route::delete('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');
    
    // Reviews
    Route::post('/bookings/{booking}/review', [App\Http\Controllers\ReviewController::class, 'store'])->name('reviews.store');
});

// ADMIN ROUTES (PROTECTED)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    
    // Services Management
    Route::resource('services', App\Http\Controllers\Admin\ServiceController::class);
    
    // Barbers Management
    Route::resource('barbers', App\Http\Controllers\Admin\BarberController::class);
    
    // Bookings Management
    Route::get('/bookings', [App\Http\Controllers\Admin\BookingController::class, 'index'])->name('bookings.index');
    Route::post('/bookings/{booking}/status', [App\Http\Controllers\Admin\BookingController::class, 'updateStatus'])->name('bookings.updateStatus');
    
    // Test route
    Route::get('/test-simple', function () {
        return view('admin.test-simple');
    })->name('test.simple');
});
