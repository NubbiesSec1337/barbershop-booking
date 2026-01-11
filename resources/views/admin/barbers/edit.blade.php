@extends('layouts.admin')

@section('content')
<div class="max-w-2xl">
    
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-white mb-2">Edit Barber</h1>
        <p class="text-gray-400">Update barber details</p>
    </div>

    <form action="{{ route('admin.barbers.update', $barber) }}" method="POST" enctype="multipart/form-data" class="bg-gray-900 border border-gray-800 rounded-xl p-8 space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-medium text-gray-300 mb-2">Photo</label>
            @if($barber->photo)
            <div class="mb-3">
                <img src="{{ $barber->photo_url }}" alt="{{ $barber->name }}" class="w-24 h-24 rounded-full object-cover border-2 border-gray-700">
            </div>
            @endif
            <input type="file" name="photo" accept="image/*" class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
            <p class="text-xs text-gray-500 mt-1">Max 2MB (JPG, PNG). Leave empty to keep current photo.</p>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-300 mb-2">Barber Name</label>
            <input type="text" name="name" value="{{ old('name', $barber->name) }}" required class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-300 mb-2">Bio</label>
            <textarea name="bio" rows="4" class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('bio', $barber->bio) }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-300 mb-2">Max Slots Per Time</label>
            <input type="number" name="max_slots_per_time" value="{{ old('max_slots_per_time', $barber->max_slots_per_time) }}" required min="1" class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
            <p class="text-xs text-gray-500 mt-1">Maximum number of bookings per time slot</p>
        </div>

        <div class="flex items-center">
            <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $barber->is_active) ? 'checked' : '' }} class="w-4 h-4 text-blue-600 bg-gray-800 border-gray-700 rounded focus:ring-blue-500">
            <label for="is_active" class="ml-2 text-sm text-gray-300">Active</label>
        </div>

        <div class="flex gap-4 pt-4">
            <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                Update Barber
            </button>
            <a href="{{ route('admin.barbers.index') }}" class="px-6 py-3 bg-gray-800 text-white rounded-lg hover:bg-gray-700 transition font-medium">
                Cancel
            </a>
        </div>
    </form>

</div>
@endsection
