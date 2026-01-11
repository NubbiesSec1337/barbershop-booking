@extends('layouts.app')
@section('title', 'Booking')

@section('content')
<div class="py-12 bg-black min-h-screen">
    <div class="max-w-6xl mx-auto px-4">
        
        {{-- Page Title --}}
        <div class="mb-12">
            <h1 class="text-3xl font-medium text-white mb-2">Book Appointment</h1>
            <p class="text-gray-400">Pilih layanan dan barber favorit Anda.</p>
        </div>

        {{-- Filter --}}
        <div class="flex flex-col sm:flex-row gap-3 mb-10 items-start sm:items-center">
            <form method="GET" action="{{ route('bookings.index') }}" class="flex gap-2">
                <input type="date" name="date" value="{{ $date }}" min="{{ now()->addDay()->format('Y-m-d') }}" 
                    class="px-4 py-2 bg-gray-900 border border-gray-800 rounded text-sm text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <button type="submit" class="px-5 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700 transition">
                    Filter
                </button>
            </form>
            @auth
            <select onchange="location.href='?filter='+this.value+'&date={{ $date }}'" 
                class="px-4 py-2 bg-gray-900 border border-gray-800 rounded text-sm text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <option value="">Semua Barber</option>
                <option value="favourite" {{ request('filter') == 'favourite' ? 'selected' : '' }}>Favorit</option>
            </select>
            @endauth
        </div>

        {{-- Services --}}
        <section class="mb-12">
            <h2 class="text-xl font-medium text-white mb-6">Layanan</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach($services as $service)
                <label class="cursor-pointer block h-full">
                    <input type="radio" name="service_id" value="{{ $service->id }}" class="sr-only peer" 
                        onchange="updateService({{ $service->id }}, '{{ $service->name }}')" required>
                    <div class="h-full p-5 bg-gray-900 border border-gray-800 rounded-lg peer-checked:border-blue-600 peer-checked:ring-2 peer-checked:ring-blue-600/20 hover:border-gray-700 transition">
                        <h3 class="text-base font-medium text-white mb-3">{{ $service->name }}</h3>
                        <p class="text-2xl font-semibold text-blue-500 mb-1">Rp {{ number_format($service->price ?? 0, 0, ',', '.') }}</p>
                        <p class="text-sm text-gray-400">{{ $service->duration_minutes ?? 30 }} menit</p>
                    </div>
                </label>
                @endforeach
            </div>
        </section>

        {{-- Barbers --}}
        <section class="mb-12">
            <h2 class="text-xl font-medium text-white mb-6">Barber</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                @forelse($barbers as $barber)
                <div class="bg-gray-900 border border-gray-800 rounded-lg p-5 flex flex-col h-full hover:border-gray-700 transition">
                    <div class="flex-grow">
                        <h3 class="text-base font-medium text-white mb-2">{{ $barber->name }}</h3>
                        <p class="text-sm text-gray-400 mb-4 line-clamp-2">{{ $barber->bio ?? 'Barber profesional' }}</p>
                        <div class="flex items-center gap-2 mb-3">
                            @if(($barber->bookings_count ?? 0) < ($barber->max_slots_per_time ?? 10))
                                <span class="inline-flex items-center px-2 py-1 bg-green-500/10 text-green-400 text-xs font-medium rounded border border-green-500/20">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="3"/></svg>
                                    Available
                                </span>
                            @else
                                <span class="inline-flex items-center px-2 py-1 bg-red-500/10 text-red-400 text-xs font-medium rounded border border-red-500/20">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="3"/></svg>
                                    Full
                                </span>
                            @endif
                        </div>
                        @auth
                        @if(in_array($barber->id, $favouriteIds ?? []))
                            <span class="inline-block px-2 py-1 bg-yellow-500/10 text-yellow-400 text-xs font-medium rounded border border-yellow-500/20 mb-3">⭐ Favorit</span>
                        @endif
                        @endauth
                    </div>
                    <div class="space-y-2 mt-4">
                        <button type="button" onclick="selectBarber({{ $barber->id }}, '{{ $barber->name }}')" 
                            class="w-full py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700 transition disabled:opacity-50 disabled:cursor-not-allowed" 
                            {{ ($barber->bookings_count ?? 0) >= ($barber->max_slots_per_time ?? 10) ? 'disabled' : '' }}>
                            Pilih
                        </button>
                        @auth
                        <button type="button" onclick="toggleFavourite({{ $barber->id }})" 
                            class="w-full py-2 text-blue-400 text-sm border border-gray-700 rounded hover:bg-gray-800 transition">
                            {{ in_array($barber->id, $favouriteIds ?? []) ? 'Hapus' : 'Favorit' }}
                        </button>
                        @endauth
                    </div>
                </div>
                @empty
                <div class="col-span-full text-center py-12 bg-gray-900 border border-gray-800 rounded-lg">
                    <p class="text-gray-400">Tidak ada barber tersedia.</p>
                </div>
                @endforelse
            </div>
        </section>

        {{-- Booking Form --}}
        <form id="bookingForm" method="POST" action="{{ route('bookings.store') }}" class="bg-gray-900 border border-gray-800 rounded-lg p-6 sm:p-8 hidden">
            @csrf
            <input type="hidden" name="service_id" id="serviceId">
            <input type="hidden" name="barber_id" id="barberId">
            <input type="hidden" name="booking_date" value="{{ $date }}">
            
            <h2 class="text-xl font-medium text-white mb-6">Konfirmasi Booking</h2>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Layanan</label>
                    <div id="selectedService" class="px-4 py-3 bg-black border border-gray-800 rounded text-sm text-white"></div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Barber</label>
                    <div id="selectedBarber" class="px-4 py-3 bg-black border border-gray-800 rounded text-sm text-white"></div>
                </div>
            </div>
            
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-300 mb-2">Waktu</label>
                <input type="time" name="booking_time" min="08:00" max="20:00" step="1800" 
                    class="w-full px-4 py-3 bg-black border border-gray-800 rounded text-sm text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                @error('booking_time')
                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <button type="submit" class="w-full py-3 bg-green-600 text-white rounded hover:bg-green-700 transition font-medium">
                Konfirmasi Booking
            </button>
        </form>

    </div>
</div>

<script>
let selectedServiceId = null;
let selectedBarberId = null;

function updateService(id, name) {
    selectedServiceId = id;
    document.getElementById('serviceId').value = id;
    document.getElementById('selectedService').textContent = name;
}

function selectBarber(id, name) {
    if (!selectedServiceId) {
        alert('Pilih layanan terlebih dahulu!');
        return;
    }
    selectedBarberId = id;
    document.getElementById('barberId').value = id;
    document.getElementById('selectedBarber').textContent = name;
    document.getElementById('bookingForm').classList.remove('hidden');
    document.getElementById('bookingForm').scrollIntoView({ behavior: 'smooth', block: 'center' });
}

@auth
function toggleFavourite(id) {
    fetch(`/bookings/${id}/favourite`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(() => location.reload())
    .catch(error => alert('Error: ' + error.message));
}
@endauth
</script>
@endsection
