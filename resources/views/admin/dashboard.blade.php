@extends('layouts.admin')

@section('content')
<div class="space-y-6 lg:space-y-8">
    
    {{-- Header --}}
    <div>
        <h1 class="text-2xl lg:text-3xl font-bold text-white mb-2">Dashboard</h1>
        <p class="text-sm lg:text-base text-gray-400">Overview of your barbershop business</p>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 lg:gap-6">
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg lg:rounded-xl p-4 lg:p-6">
            <div class="flex items-center justify-between mb-3 lg:mb-4">
                <div class="w-10 h-10 lg:w-12 lg:h-12 bg-white/20 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 lg:w-6 lg:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>
            <div class="text-xl lg:text-3xl font-bold text-white mb-1">{{ $totalBookings }}</div>
            <div class="text-blue-100 text-xs lg:text-sm">Total Bookings</div>
        </div>

        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg lg:rounded-xl p-4 lg:p-6">
            <div class="flex items-center justify-between mb-3 lg:mb-4">
                <div class="w-10 h-10 lg:w-12 lg:h-12 bg-white/20 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 lg:w-6 lg:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <div class="text-xl lg:text-3xl font-bold text-white mb-1">
                <span class="text-base lg:text-3xl">Rp</span> {{ number_format($totalRevenue / 1000, 0) }}K
            </div>
            <div class="text-green-100 text-xs lg:text-sm">Total Revenue</div>
        </div>

        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg lg:rounded-xl p-4 lg:p-6">
            <div class="flex items-center justify-between mb-3 lg:mb-4">
                <div class="w-10 h-10 lg:w-12 lg:h-12 bg-white/20 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 lg:w-6 lg:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
            </div>
            <div class="text-xl lg:text-3xl font-bold text-white mb-1">{{ $totalBarbers }}</div>
            <div class="text-purple-100 text-xs lg:text-sm">Total Barbers</div>
        </div>

        <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg lg:rounded-xl p-4 lg:p-6">
            <div class="flex items-center justify-between mb-3 lg:mb-4">
                <div class="w-10 h-10 lg:w-12 lg:h-12 bg-white/20 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 lg:w-6 lg:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
            </div>
            <div class="text-xl lg:text-3xl font-bold text-white mb-1">{{ $totalCustomers }}</div>
            <div class="text-orange-100 text-xs lg:text-sm">Total Customers</div>
        </div>
    </div>

    {{-- Charts Row --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 lg:gap-6">
        {{-- Bookings Chart --}}
        <div class="bg-gray-900 border border-gray-800 rounded-lg lg:rounded-xl p-4 lg:p-6">
            <h3 class="text-base lg:text-lg font-semibold text-white mb-4">Bookings Trend (Last 7 Days)</h3>
            @if($bookingsChart->count() > 0)
            <div class="relative h-64 lg:h-auto">
                <canvas id="bookingsChart"></canvas>
            </div>
            @else
            <div class="text-center py-8 lg:py-12 text-gray-500">
                <svg class="w-10 h-10 lg:w-12 lg:h-12 mx-auto mb-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                <p class="text-xs lg:text-sm">No booking data available</p>
            </div>
            @endif
        </div>

        {{-- Popular Services --}}
        <div class="bg-gray-900 border border-gray-800 rounded-lg lg:rounded-xl p-4 lg:p-6">
            <h3 class="text-base lg:text-lg font-semibold text-white mb-4">Popular Services</h3>
            @if($popularServices->count() > 0 && $totalBookings > 0)
            <div class="space-y-3 lg:space-y-4">
                @foreach($popularServices as $service)
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs lg:text-sm text-gray-300 truncate max-w-[60%]">{{ $service->name }}</span>
                        <span class="text-xs lg:text-sm text-white font-semibold">{{ $service->bookings_count }}</span>
                    </div>
                    <div class="w-full bg-gray-800 rounded-full h-2">
                        <div class="bg-blue-500 h-2 rounded-full transition-all duration-500" style="width: {{ ($service->bookings_count / $totalBookings) * 100 }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-8 lg:py-12 text-gray-500">
                <svg class="w-10 h-10 lg:w-12 lg:h-12 mx-auto mb-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.121 14.121L19 19m-7-7l7-7m-7 7l-2.879 2.879M12 12L9.121 9.121m0 5.758a3 3 0 10-4.243 4.243 3 3 0 004.243-4.243zm0-5.758a3 3 0 10-4.243-4.243 3 3 0 004.243 4.243z"/>
                </svg>
                <p class="text-xs lg:text-sm">No service data available</p>
            </div>
            @endif
        </div>
    </div>

    {{-- Recent Bookings --}}
    <div class="bg-gray-900 border border-gray-800 rounded-lg lg:rounded-xl p-4 lg:p-6">
        <div class="flex items-center justify-between mb-4 lg:mb-6">
            <h3 class="text-base lg:text-lg font-semibold text-white">Recent Bookings</h3>
            <a href="{{ route('admin.bookings.index') }}" class="text-blue-400 hover:text-blue-300 text-xs lg:text-sm font-medium">View All</a>
        </div>
        @if($recentBookings->count() > 0)
        {{-- Desktop Table --}}
        <div class="hidden lg:block overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-800">
                        <th class="text-left py-3 px-4 text-gray-400 font-medium text-sm">Customer</th>
                        <th class="text-left py-3 px-4 text-gray-400 font-medium text-sm">Service</th>
                        <th class="text-left py-3 px-4 text-gray-400 font-medium text-sm">Barber</th>
                        <th class="text-left py-3 px-4 text-gray-400 font-medium text-sm">Date</th>
                        <th class="text-left py-3 px-4 text-gray-400 font-medium text-sm">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentBookings as $booking)
                    <tr class="border-b border-gray-800 hover:bg-gray-800/50">
                        <td class="py-3 px-4 text-white">{{ $booking->user->name }}</td>
                        <td class="py-3 px-4 text-gray-300">{{ $booking->service->name }}</td>
                        <td class="py-3 px-4 text-gray-300">{{ $booking->barber->name }}</td>
                        <td class="py-3 px-4 text-gray-300">{{ $booking->formatted_date }}</td>
                        <td class="py-3 px-4">
                            <span class="inline-block px-2 py-1 text-xs font-medium rounded bg-{{ $booking->status_color }}-500/10 text-{{ $booking->status_color }}-400 border border-{{ $booking->status_color }}-500/20">
                                {{ $booking->status_label }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Mobile Cards --}}
        <div class="lg:hidden space-y-3">
            @foreach($recentBookings as $booking)
            <div class="bg-gray-800/50 border border-gray-700 rounded-lg p-4">
                <div class="flex items-start justify-between mb-3">
                    <div>
                        <div class="text-white font-medium text-sm mb-1">{{ $booking->user->name }}</div>
                        <div class="text-gray-400 text-xs">{{ $booking->service->name }}</div>
                    </div>
                    <span class="inline-block px-2 py-1 text-xs font-medium rounded bg-{{ $booking->status_color }}-500/10 text-{{ $booking->status_color }}-400 border border-{{ $booking->status_color }}-500/20">
                        {{ $booking->status_label }}
                    </span>
                </div>
                <div class="flex items-center justify-between text-xs text-gray-400">
                    <span>{{ $booking->barber->name }}</span>
                    <span>{{ $booking->formatted_date }}</span>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-8 lg:py-12 text-gray-500">
            <svg class="w-12 h-12 lg:w-16 lg:h-16 mx-auto mb-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <h4 class="text-sm lg:text-base font-medium text-gray-400 mb-2">No Bookings Yet</h4>
            <p class="text-xs lg:text-sm text-gray-500 mb-4">Start by adding services and barbers</p>
            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                <a href="{{ route('admin.services.create') }}" class="px-4 py-2 bg-blue-600 text-white text-xs lg:text-sm rounded-lg hover:bg-blue-700 transition">
                    Add Service
                </a>
                <a href="{{ route('admin.barbers.create') }}" class="px-4 py-2 bg-gray-800 text-white text-xs lg:text-sm rounded-lg hover:bg-gray-700 transition">
                    Add Barber
                </a>
            </div>
        </div>
        @endif
    </div>

</div>

@if($bookingsChart->count() > 0)
<script>
// Bookings Chart
const ctx = document.getElementById('bookingsChart').getContext('2d');
new Chart(ctx, {
    type: 'line',
     {
        labels: {!! json_encode($bookingsChart->pluck('date')->map(fn($d) => \Carbon\Carbon::parse($d)->format('d M'))) !!},
        datasets: [{
            label: 'Bookings',
             {!! json_encode($bookingsChart->pluck('count')) !!},
            borderColor: 'rgb(59, 130, 246)',
            backgroundColor: 'rgba(59, 130, 246, 0.1)',
            tension: 0.4,
            fill: true,
            pointRadius: 4,
            pointHoverRadius: 6
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: {
                display: false
            },
            tooltip: {
                backgroundColor: 'rgba(17, 24, 39, 0.9)',
                padding: 12,
                titleColor: '#fff',
                bodyColor: '#fff',
                borderColor: '#374151',
                borderWidth: 1
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: { 
                    color: '#9CA3AF',
                    stepSize: 1,
                    font: {
                        size: window.innerWidth < 768 ? 10 : 12
                    }
                },
                grid: { 
                    color: '#1F2937',
                    drawBorder: false
                }
            },
            x: {
                ticks: { 
                    color: '#9CA3AF',
                    font: {
                        size: window.innerWidth < 768 ? 10 : 12
                    }
                },
                grid: { 
                    color: '#1F2937',
                    drawBorder: false
                }
            }
        },
        interaction: {
            intersect: false,
            mode: 'index'
        }
    }
});
</script>
@endif
@endsection
