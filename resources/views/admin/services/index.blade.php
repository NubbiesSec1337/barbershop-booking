@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-white mb-2">Services Management</h1>
            <p class="text-gray-400">Manage your barbershop services</p>
        </div>
        <a href="{{ route('admin.services.create') }}" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
            + Add Service
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($services as $service)
        <div class="bg-gray-900 border border-gray-800 rounded-xl p-6">
            <div class="flex items-start justify-between mb-4">
                <div class="flex-1">
                    <h3 class="text-xl font-semibold text-white mb-2">{{ $service->name }}</h3>
                    <p class="text-gray-400 text-sm mb-4">{{ $service->description ?? 'No description' }}</p>
                </div>
                @if($service->is_active)
                <span class="px-2 py-1 bg-green-500/10 text-green-400 text-xs font-medium rounded border border-green-500/20">Active</span>
                @else
                <span class="px-2 py-1 bg-red-500/10 text-red-400 text-xs font-medium rounded border border-red-500/20">Inactive</span>
                @endif
            </div>
            <div class="space-y-2 mb-6">
                <div class="flex items-center justify-between text-sm">
                    <span class="text-gray-400">Price</span>
                    <span class="text-white font-semibold">Rp {{ number_format($service->price, 0, ',', '.') }}</span>
                </div>
                <div class="flex items-center justify-between text-sm">
                    <span class="text-gray-400">Duration</span>
                    <span class="text-white">{{ $service->duration_minutes }} min</span>
                </div>
                <div class="flex items-center justify-between text-sm">
                    <span class="text-gray-400">Total Bookings</span>
                    <span class="text-white">{{ $service->bookings_count }}</span>
                </div>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.services.edit', $service) }}" class="flex-1 px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-700 transition text-center text-sm font-medium">
                    Edit
                </a>
                <form action="{{ route('admin.services.destroy', $service) }}" method="POST" onsubmit="return confirm('Delete this service?')">
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
