@extends('layouts.admin')

@section('content')
<div class="max-w-2xl">
    
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-white mb-2">Edit Service</h1>
        <p class="text-gray-400">Update service details</p>
    </div>

    <form action="{{ route('admin.services.update', $service) }}" method="POST" class="bg-gray-900 border border-gray-800 rounded-xl p-8 space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-medium text-gray-300 mb-2">Service Name</label>
            <input type="text" name="name" value="{{ old('name', $service->name) }}" required class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-300 mb-2">Description</label>
            <textarea name="description" rows="3" class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description', $service->description) }}</textarea>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Price (Rp)</label>
                <input type="number" name="price" value="{{ old('price', $service->price) }}" required min="0" step="1000" class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Duration (minutes)</label>
                <input type="number" name="duration_minutes" value="{{ old('duration_minutes', $service->duration_minutes) }}" required min="1" class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        </div>

        <div class="flex items-center">
            <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $service->is_active) ? 'checked' : '' }} class="w-4 h-4 text-blue-600 bg-gray-800 border-gray-700 rounded focus:ring-blue-500">
            <label for="is_active" class="ml-2 text-sm text-gray-300">Active</label>
        </div>

        <div class="flex gap-4 pt-4">
            <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                Update Service
            </button>
            <a href="{{ route('admin.services.index') }}" class="px-6 py-3 bg-gray-800 text-white rounded-lg hover:bg-gray-700 transition font-medium">
                Cancel
            </a>
        </div>
    </form>

</div>
@endsection
