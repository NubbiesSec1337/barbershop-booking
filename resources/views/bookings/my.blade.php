@extends('layouts.app')
@section('title', 'Booking Saya')

@section('content')
<div class="py-12 bg-gray-50 min-h-screen">
    <div class="max-w-4xl mx-auto px-4">
        
        {{-- Page Title --}}
        <div class="mb-8">
            <h1 class="text-3xl font-medium text-gray-900 mb-2">Booking Saya</h1>
            <p class="text-gray-600">Riwayat semua booking Anda.</p>
        </div>

        {{-- Bookings List --}}
        @forelse($bookings as $booking)
        <div class="bg-white border border-gray-200 rounded-lg p-5 sm:p-6 mb-4 hover:border-gray-300 transition">
            <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                
                {{-- Left: Info --}}
                <div class="flex-grow">
                    <div class="flex items-start gap-3 mb-3">
                        <div class="flex-shrink-0 w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.121 14.121L19 19m-7-7l7-7m-7 7l-2.879 2.879M12 12L9.121 9.121m0 5.758a3 3 0 10-4.243 4.243 3 3 0 004.243-4.243zm0-5.758a3 3 0 10-4.243-4.243 3 3 0 004.243 4.243z"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-base sm:text-lg font-medium text-gray-900">{{ $booking->service->name ?? 'Service' }}</h2>
                            <p class="text-sm text-gray-600">dengan {{ $booking->barber->name ?? 'Barber' }}</p>
                        </div>
                    </div>
                    
                    {{-- Date & Time --}}
                    <div class="flex flex-wrap gap-4 text-sm text-gray-700">
                        <div class="flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span>{{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>{{ \Carbon\Carbon::parse($booking->booking_time)->format('H:i') }}</span>
                        </div>
                    </div>
                </div>

                {{-- Right: Status & Actions --}}
                <div class="flex flex-row sm:flex-col items-center sm:items-end gap-3">
                    {{-- Status --}}
                    @php
                        $statusColors = [
                            'pending' => 'bg-yellow-50 text-yellow-700',
                            'confirmed' => 'bg-green-50 text-green-700',
                            'cancelled' => 'bg-red-50 text-red-700',
                            'completed' => 'bg-blue-50 text-blue-700',
                        ];
                        $status = $booking->status ?? 'pending';
                        $colorClass = $statusColors[$status] ?? 'bg-gray-50 text-gray-700';
                    @endphp
                    <span class="inline-flex items-center px-2.5 py-1 text-xs font-medium rounded {{ $colorClass }} capitalize">
                        {{ $status }}
                    </span>
                    
                    {{-- Price --}}
                    @if($booking->service->price ?? null)
                    <p class="text-lg font-semibold text-gray-900">Rp {{ number_format($booking->service->price, 0, ',', '.') }}</p>
                    @endif
                    
                    {{-- Cancel --}}
                    @if($status === 'pending')
                    <form method="POST" action="{{ route('bookings.cancel', $booking->id) }}" onsubmit="return confirm('Yakin batalkan?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-xs text-red-600 hover:text-red-800 underline">
                            Batalkan
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
        @empty
        {{-- Empty State --}}
        <div class="bg-white border border-gray-200 rounded-lg p-12 text-center">
            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Booking</h3>
            <p class="text-gray-600 mb-6">Anda belum memiliki riwayat booking.</p>
            <a href="{{ route('bookings.index') }}" class="inline-block px-6 py-2.5 bg-blue-600 text-white text-sm rounded hover:bg-blue-700 transition">
                Buat Booking Sekarang
            </a>
        </div>
        @endforelse

    </div>
</div>
@endsection
