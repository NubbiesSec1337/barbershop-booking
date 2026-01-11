@extends('layouts.app')
@section('title', 'Booking Saya')

@section('content')
<div class="space-y-8">
    <div class="flex items-center justify-between">
        <h1 class="text-5xl font-bold bg-gradient-to-r from-slate-900 to-blue-900 bg-clip-text">Booking Saya</h1>
        <a href="{{ route('bookings.index') }}" class="px-10 py-5 bg-blue-600 text-white rounded-3xl font-bold text-xl hover:bg-blue-700 shadow-xl hover:shadow-2xl transition-all">+ Booking Baru</a>
    </div>

    @forelse($bookings as $booking)
    <div class="bg-white rounded-3xl p-10 border border-slate-200 shadow-xl hover:shadow-2xl transition-all">
        <div class="flex flex-col lg:flex-row gap-8 items-start lg:items-center">
            <div class="flex items-center gap-6 flex-1">
                <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center flex-shrink-0">
                    <span class="text-3xl">✂️</span>
                </div>
                <div>
                    <h3 class="text-3xl font-bold text-slate-900 mb-2">{{ $booking->service->name }}</h3>
                    <p class="text-2xl text-slate-700 mb-1">dengan {{ $booking->barber->name }}</p>
                    <p class="text-xl text-slate-600">{{ $booking->booking_date }} | {{ $booking->booking_time }}</p>
                </div>
            </div>
            <div class="flex flex-col sm:flex-row gap-4 items-end sm:items-center">
                <div class="text-3xl font-bold text-emerald-600">Rp {{ number_format($booking->service->price,0,',','.') }}</div>
                <span class="px-6 py-3 rounded-2xl font-bold text-xl bg-gradient-to-r
                    @if($booking->status == 'pending') from-yellow-400 to-orange-400 text-white
                    @elseif($booking->status == 'confirmed') from-emerald-400 to-teal-400 text-white
                    @else from-red-400 to-rose-400 text-white @endif">
                    {{ ucfirst($booking->status) }}
                </span>
            </div>
        </div>
    </div>
    @empty
    <div class="text-center py-32">
        <div class="w-32 h-32 mx-auto mb-12 bg-slate-100 rounded-3xl flex items-center justify-center">
            <span class="text-6xl">📅</span>
        </div>
        <h2 class="text-4xl font-bold text-slate-900 mb-4">Belum ada booking</h2>
        <p class="text-xl text-slate-600 mb-8 max-w-md mx-auto">Mulai booking barber favorit Anda sekarang</p>
        <a href="{{ route('bookings.index') }}" class="inline-block px-12 py-6 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-3xl font-bold text-2xl shadow-2xl hover:shadow-3xl transition-all">Mulai Booking</a>
    </div>
    @endforelse
</div>
@endsection
