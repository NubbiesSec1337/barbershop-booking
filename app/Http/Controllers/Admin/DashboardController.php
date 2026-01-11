<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Service;
use App\Models\Barber;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Stats
        $totalBookings = Booking::count();
        $totalRevenue = Booking::whereHas('service')->with('service')->get()->sum(function($booking) {
            return $booking->service->price ?? 0;
        });
        $totalBarbers = Barber::count();
        $totalCustomers = User::where('role', 'customer')->count();

        // Recent bookings
        $recentBookings = Booking::with(['user', 'service', 'barber'])
            ->latest()
            ->take(10)
            ->get();

        // Popular services
        $popularServices = Service::withCount('bookings')
            ->orderBy('bookings_count', 'desc')
            ->take(5)
            ->get();

        // Bookings per day (last 7 days)
        $bookingsChart = Booking::select(
            DB::raw('DATE(booking_date) as date'),
            DB::raw('COUNT(*) as count')
        )
        ->where('booking_date', '>=', now()->subDays(7))
        ->groupBy('date')
        ->orderBy('date')
        ->get();

        return view('admin.dashboard', compact(
            'totalBookings',
            'totalRevenue',
            'totalBarbers',
            'totalCustomers',
            'recentBookings',
            'popularServices',
            'bookingsChart'
        ));
    }
}
