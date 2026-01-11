<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Service;
use App\Models\Barber;
use App\Models\Booking;
use Carbon\Carbon;

class BookingController extends Controller
{
    /**
     * Tampilkan halaman booking utama dengan barber available
     */
    public function index(Request $request)
    {
        $services = Service::all();
        $date = $request->get('date', now()->addDay()->format('Y-m-d'));

        $query = Barber::withCount([
            'bookings' => function ($query) use ($date) {
                $query->whereDate('booking_date', $date);
            }
        ]);

        // Filter favorit jika user login dan pilih filter
        if (Auth::check() && $request->get('filter') === 'favourite') {
            $query->whereHas('users', function ($q) {
                $q->where('user_id', Auth::id());
            });
        }

        $barbers = $query->get();
        $favouriteIds = Auth::check() ? Auth::user()->favouriteBarbers->pluck('id')->toArray() : [];

        return view('bookings.index', compact('services', 'barbers', 'date', 'favouriteIds'));
    }

    /**
     * Simpan booking baru dengan validasi slot
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'barber_id' => 'required|exists:barbers,id',
            'booking_date' => 'required|date|after_or_equal:today',
            'booking_time' => 'required|date_format:H:i|after:07:59|before:20:01',
        ]);

        $barber = Barber::findOrFail($validated['barber_id']);

        // Cek jumlah booking di slot tersebut
        $existing = Booking::where('barber_id', $validated['barber_id'])
            ->whereDate('booking_date', $validated['booking_date'])
            ->where('booking_time', $validated['booking_time'])
            ->count();

        if ($existing >= $barber->max_slots_per_time) {
            return back()->withErrors([
                'barber_id' => "Slot {$barber->name} sudah penuh pada waktu itu."
            ])->withInput();
        }

        Booking::create(array_merge($validated, [
            'user_id' => Auth::id(),
            'status' => 'pending'
        ]));

        return redirect()->route('bookings.my')
            ->with('success', "Booking dengan {$barber->name} berhasil! Menunggu konfirmasi.");
    }

    /**
     * Tampilkan daftar booking user
     */
    public function my()
    {
        $bookings = Auth::user()
            ->bookings()
            ->with(['service', 'barber'])
            ->latest()
            ->get();

        return view('bookings.my', compact('bookings'));
    }

    /**
     * Toggle favorit barber (AJAX)
     */
    public function toggleFavourite(Request $request, Barber $barber)
    {
        $user = Auth::user();

        if ($user->favouriteBarbers()->where('barber_id', $barber->id)->exists()) {
            $user->favouriteBarbers()->detach($barber->id);
            return response()->json(['success' => true, 'is_fav' => false]);
        }

        $user->favouriteBarbers()->attach($barber->id);
        return response()->json(['success' => true, 'is_fav' => true]);
    }
}
