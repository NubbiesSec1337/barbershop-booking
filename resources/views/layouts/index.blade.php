@extends('layouts.app')
@section('title', 'Pilih Layanan & Barber')

@section('content')
<div class="space-y-12 text-center">
    <div>
        <h1 class="text-5xl md:text-6xl font-bold bg-gradient-to-r from-slate-900 via-blue-900 to-indigo-900 bg-clip-text mb-4">Booking Potong Rambut</h1>
        <p class="text-xl text-slate-600 max-w-lg mx-auto">Pilih layanan, barber favorit, dan slot. Cepat untuk UMKM barbershop.</p>
    </div>

    <!-- Services -->
    <section class="bg-white/50 backdrop-blur-sm rounded-3xl p-10 border border-slate-200 shadow-xl">
        <h2 class="text-3xl font-bold text-slate-900 mb-10">Layanan</h2>
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($services as $service)
            <label class="cursor-pointer group">
                <input type="radio" name="service_id" value="{{ $service->id }}" class="sr-only" onchange="updateService({{ $service->id }})" required>
                <div class="p-8 rounded-2xl border-2 border-slate-200 hover:border-blue-400 hover:shadow-2xl transition-all bg-white group-hover:-translate-y-2">
                    <h3 class="text-xl font-bold text-slate-900 mb-3">{{ $service->name }}</h3>
                    <div class="text-3xl font-bold text-blue-600 mb-2">Rp {{ number_format($service->price ?? 0,0,',','.') }}</div>
                    <div class="text-slate-600 text-lg">{{ $service->duration_minutes ?? 30 }} menit</div>
                </div>
            </label>
            @endforeach
        </div>
    </section>

    <!-- Barbers -->
    <section class="bg-white/50 backdrop-blur-sm rounded-3xl p-10 border border-slate-200 shadow-xl">
        <div class="flex flex-wrap gap-4 mb-10 justify-center">
            {{-- GET Form - No CSRF needed --}}
            <form method="GET" action="{{ route('bookings.index') }}" class="flex gap-3">
                <input type="date" name="date" value="{{ $date }}" min="{{ now()->addDay()->format('Y-m-d') }}" class="px-6 py-3 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-blue-500">
                <button type="submit" class="px-8 py-3 bg-blue-600 text-white rounded-2xl font-bold hover:bg-blue-700">Cek Slot</button>
            </form>
            @auth
            <select onchange="filterBarbers(this.value)" class="px-6 py-3 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-blue-500">
                <option value="">Semua Barber</option>
                <option value="favourite" {{ request('filter') == 'favourite' ? 'selected' : '' }}>Favorit Saya</option>
            </select>
            @endauth
        </div>
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
            @forelse($barbers as $barber)
            <div class="group relative">
                <div class="p-8 rounded-2xl border border-slate-200 hover:shadow-2xl hover:border-blue-300 transition-all bg-white h-full flex flex-col">
                    <h3 class="text-2xl font-bold text-slate-900 mb-3 text-center">{{ $barber->name }}</h3>
                    <p class="text-slate-600 mb-6 text-center leading-relaxed">{{ $barber->bio ?? 'Barber berpengalaman' }}</p>
                    <div class="mb-6 text-center">
                        @if(($barber->bookings_count ?? 0) < ($barber->max_slots_per_time ?? 10))
                            <span class="px-6 py-3 bg-emerald-100 text-emerald-800 rounded-2xl font-bold text-lg">✅ Available</span>
                        @else
                            <span class="px-6 py-3 bg-red-100 text-red-800 rounded-2xl font-bold text-lg">❌ Penuh</span>
                        @endif
                    </div>
                    @auth
                    @if(in_array($barber->id, $favouriteIds ?? []))
                        <span class="block text-center px-4 py-2 bg-emerald-500 text-white rounded-xl font-bold mb-6 mx-auto w-fit">⭐ Favorit</span>
                    @endif
                    @endauth
                    <button onclick="selectBarber({{ $barber->id }})" class="w-full bg-gradient-to-r from-blue-600 to-blue-700 text-white py-4 rounded-2xl font-bold text-lg hover:shadow-xl transition-all {{ ($barber->bookings_count ?? 0) >= ($barber->max_slots_per_time ?? 10) ? 'opacity-50 cursor-not-allowed' : '' }}" {{ ($barber->bookings_count ?? 0) >= ($barber->max_slots_per_time ?? 10) ? 'disabled' : '' }}>
                        Pilih {{ $barber->name }}
                    </button>
                    @auth
                    <button type="button" onclick="toggleFavourite({{ $barber->id }})" class="w-full mt-3 text-blue-600 hover:text-blue-800 font-semibold py-2 rounded-xl hover:bg-blue-50 transition-all">
                        {{ in_array($barber->id, $favouriteIds ?? []) ? 'Bukan Favorit' : 'Jadikan Favorit' }}
                    </button>
                    @endauth
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-12">
                <p class="text-2xl text-slate-500">Tidak ada barber tersedia untuk tanggal ini.</p>
            </div>
            @endforelse
        </div>
    </section>

    <!-- Form Booking -->
    <form id="bookingForm" method="POST" action="{{ route('bookings.store') }}" class="bg-white rounded-3xl p-10 border border-slate-200 shadow-2xl space-y-6 opacity-0 invisible overflow-hidden max-h-0 transition-all duration-700 ease-in-out" style="max-height: 1000px;">
        @csrf
        <input type="hidden" name="service_id" id="serviceId">
        <input type="hidden" name="barber_id" id="barberId">
        <input type="hidden" name="booking_date" name="booking_date" value="{{ $date }}">
        <h2 class="text-3xl font-bold text-slate-900 text-center">Konfirmasi Booking</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-lg font-bold text-slate-900 mb-2">Layanan Terpilih</label>
                <span id="selectedService" class="px-6 py-4 bg-blue-50 border-2 border-blue-200 rounded-2xl block text-xl font-bold"></span>
            </div>
            <div>
                <label class="block text-lg font-bold text-slate-900 mb-2">Barber Terpilih</label>
                <span id="selectedBarber" class="px-6 py-4 bg-emerald-50 border-2 border-emerald-200 rounded-2xl block text-xl font-bold"></span>
            </div>
        </div>
        <label class="block w-full">
            <span class="text-lg font-bold text-slate-900 mb-3 block">Pilih Waktu Slot ({{ $services->first()->duration_minutes ?? 30 }} menit)</span>
            <input type="time" name="booking_time" class="w-full px-6 py-4 border-2 border-slate-200 rounded-2xl text-xl focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 shadow-sm transition-all" min="08:00" max="20:00" step="1800" required>
        </label>
        @error('booking_time') <p class="text-red-500 text-lg mt-2 bg-red-50 p-3 rounded-xl">{{ $message }}</p> @enderror
        <button type="submit" class="w-full bg-gradient-to-r from-emerald-600 to-teal-600 text-white py-6 rounded-3xl text-2xl font-bold shadow-2xl hover:shadow-3xl hover:scale-[1.02] transition-all disabled:opacity-50" id="submitBtn">
            ✅ Konfirmasi Booking Sekarang
        </button>
    </form>
</div>

<script>
let selectedServiceId = null;
let selectedBarberId = null;

function updateService(id) {
    selectedServiceId = id;
    document.getElementById('serviceId').value = id;
    // Update UI selected service
    const serviceName = document.querySelector(`input[value="${id}"]`).closest('label').querySelector('h3').textContent;
    document.getElementById('selectedService').textContent = serviceName;
}

function selectBarber(id) {
    if (!selectedServiceId) {
        alert('Pilih layanan dulu!');
        return;
    }
    selectedBarberId = id;
    document.getElementById('barberId').value = id;
    const barberName = event.target.closest('.group').querySelector('h3').textContent;
    document.getElementById('selectedBarber').textContent = barberName;
    
    // Show form smooth
    const form = document.getElementById('bookingForm');
    form.classList.remove('opacity-0', 'invisible', 'max-h-0');
    form.classList.add('opacity-100', 'visible');
    form.style.maxHeight = '1200px';
}

function toggleFavourite(id) {
    const btn = event.target;
    btn.disabled = true;
    btn.innerHTML = 'Loading...';
    
    fetch(`/bookings/${id}/favourite`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify({})
    })
    .then(response => {
        if (!response.ok) throw new Error('Gagal toggle favourite');
        return response.json();
    })
    .then(data => {
        location.reload();  // Reload untuk update UI
    })
    .catch(error => {
        alert('Error: ' + error.message);
        btn.disabled = false;
        btn.innerHTML = btn.dataset.originalText || 'Coba lagi';
    });
}

function filterBarbers(value) {
    const url = new URL(window.location);
    url.searchParams.set('filter', value);
    window.location.href = url;
}

// Submit loading
document.getElementById('bookingForm').addEventListener('submit', function() {
    const btn = document.getElementById('submitBtn');
    btn.disabled = true;
    btn.innerHTML = '⏳ Memproses Booking...';
});
</script>
@endsection
