@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-white mb-2">Bookings Management</h1>
            <p class="text-gray-400">Manage all customer bookings</p>
        </div>
    </div>

    {{-- Filters --}}
    <form method="GET" class="bg-gray-900 border border-gray-800 rounded-xl p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Status</label>
                <select name="status" class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">All Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Date</label>
                <input type="date" name="date" value="{{ request('date') }}" class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="flex items-end">
                <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                    Filter
                </button>
                <a href="{{ route('admin.bookings.index') }}" class="ml-2 px-6 py-3 bg-gray-800 text-white rounded-lg hover:bg-gray-700 transition font-medium">
                    Reset
                </a>
            </div>
        </div>
    </form>

    {{-- Bookings Table --}}
    <div class="bg-gray-900 border border-gray-800 rounded-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-800 bg-gray-800/50">
                        <th class="text-left py-4 px-6 text-gray-300 font-semibold text-sm">ID</th>
                        <th class="text-left py-4 px-6 text-gray-300 font-semibold text-sm">Customer</th>
                        <th class="text-left py-4 px-6 text-gray-300 font-semibold text-sm">Service</th>
                        <th class="text-left py-4 px-6 text-gray-300 font-semibold text-sm">Barber</th>
                        <th class="text-left py-4 px-6 text-gray-300 font-semibold text-sm">Date & Time</th>
                        <th class="text-left py-4 px-6 text-gray-300 font-semibold text-sm">Status</th>
                        <th class="text-left py-4 px-6 text-gray-300 font-semibold text-sm">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $booking)
                    <tr class="border-b border-gray-800 hover:bg-gray-800/30">
                        <td class="py-4 px-6 text-gray-400">#{{ $booking->id }}</td>
                        <td class="py-4 px-6 text-white">{{ $booking->user->name }}</td>
                        <td class="py-4 px-6 text-gray-300">{{ $booking->service->name }}</td>
                        <td class="py-4 px-6 text-gray-300">{{ $booking->barber->name }}</td>
                        <td class="py-4 px-6 text-gray-300">
                            {{ $booking->formatted_date }}<br>
                            <span class="text-sm text-gray-500">{{ $booking->formatted_time }}</span>
                        </td>
                        <td class="py-4 px-6">
                            <form action="{{ route('admin.bookings.updateStatus', $booking) }}" method="POST" onchange="this.submit()">
                                @csrf
                                <select name="status" class="px-3 py-1 text-xs font-medium rounded bg-{{ $booking->status_color }}-500/10 text-{{ $booking->status_color }}-400 border border-{{ $booking->status_color }}-500/20 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                    <option value="completed" {{ $booking->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </form>
                        </td>
                        <td class="py-4 px-6">
                            @if($booking->review)
                            <span class="text-yellow-400 text-sm">⭐ {{ $booking->review->rating }}/5</span>
                            @else
                            <span class="text-gray-500 text-sm">No review</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-12 text-center text-gray-500">
                            No bookings found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination --}}
    <div class="mt-6">
        {{ $bookings->links() }}
    </div>

</div>
@endsection
