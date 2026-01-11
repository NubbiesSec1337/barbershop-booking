<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BarberController extends Controller
{
    public function index()
    {
        $barbers = Barber::withCount('bookings')
            ->withAvg('reviews', 'rating')
            ->get();
        return view('admin.barbers.index', compact('barbers'));
    }

    public function create()
    {
        return view('admin.barbers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'max_slots_per_time' => 'required|integer|min:1',
            'is_active' => 'boolean',
            'photo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('barbers', 'public');
        }

        Barber::create($validated);

        return redirect()->route('admin.barbers.index')
            ->with('success', 'Barber created successfully.');
    }

    public function edit(Barber $barber)
    {
        return view('admin.barbers.edit', compact('barber'));
    }

    public function update(Request $request, Barber $barber)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'max_slots_per_time' => 'required|integer|min:1',
            'is_active' => 'boolean',
            'photo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            // Delete old photo
            if ($barber->photo) {
                Storage::disk('public')->delete($barber->photo);
            }
            $validated['photo'] = $request->file('photo')->store('barbers', 'public');
        }

        $barber->update($validated);

        return redirect()->route('admin.barbers.index')
            ->with('success', 'Barber updated successfully.');
    }

    public function destroy(Barber $barber)
    {
        if ($barber->photo) {
            Storage::disk('public')->delete($barber->photo);
        }
        $barber->delete();
        return redirect()->route('admin.barbers.index')
            ->with('success', 'Barber deleted successfully.');
    }
}
