@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-white mb-2">Barbers Management</h1>
            <p class="text-gray-400">Manage your team of barbers</p>
        </div>
        <a href="{{ route('admin.barbers.create') }}" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
            + Add Barber
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($barbers as $barber)
        <div class="bg-gray-900 border border-gray-800 rounded-xl p-6">
            <div class="flex items-start gap-4 mb-4">
                @if($barber->photo)
                <img src="{{ $barber->photo_url }}" alt="{{ $barber->name }}" class="w-16 h-16 rounded-full object-cover border-2 border-gray-700">
                @else
                <div class="w-16 h-16 rounded-full bg-gray-800 flex items-center justify-center border-2 border-gray-700">
                    <svg class="w-8 h-8 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                @endif
                <div class="flex-1">
                    <h3 class="text-xl font-semibold text-white mb-1">{{ $barber->name }}</h3>
                    @if($barber->is_active)
                    <span class="inline-block px-2 py-1 bg-green-500/10 text-green-400 text-xs font-medium rounded border border-green-500/20">Active</span>
                    @else
                    <span class="inline-block px-2 py-1 bg-red-500/10 text-red-400 text-xs font-medium rounded border border-red-500/20">Inactive</span>
                    @endif
                </div>
            </div>

            <p class="text-gray-400 text-sm mb-4 line-clamp-2">{{ $barber->bio ?? 'No bio available' }}</p>

            <div class="space-y-2 mb-4 pb-4 border-b border-gray-800">
                <div class="flex items-center justify-between text-sm">
                    <span class="text-gray-400">Rating</span>
                    <div class="flex items-center gap-1">
                        <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <span class="text-white font-semibold">{{ number_format($barber->reviews_avg_rating ?? 0, 1) }}</span>
                        <span class="text-gray-500">({{ $barber->reviews_count ?? 0 }})</span>
                    </div>
                </div>
                <div class="flex items-center justify-between text-sm">
                    <span class="text-gray-400">Total Bookings</span>
                    <span class="text-white font-semibold">{{ $barber->bookings_count }}</span>
                </div>
                <div class="flex items-center justify-between text-sm">
                    <span class="text-gray-400">Max Slots</span>
                    <span class="text-white">{{ $barber->max_slots_per_time }}</span>
                </div>
            </div>

            <div class="flex gap-2">
                <a href="{{ route('admin.barbers.edit', $barber) }}" class="flex-1 px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-700 transition text-center text-sm font-medium">
                    Edit
                </a>
                <form action="{{ route('admin.barbers.destroy', $barber) }}" method="POST" onsubmit="return confirm('Delete this barber?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-500/10 text-red-400 rounded-lg hover:bg-red-500/20 transition text-sm font-medium border border-red-500/20">
                        Delete
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>

</div>
@endsection
