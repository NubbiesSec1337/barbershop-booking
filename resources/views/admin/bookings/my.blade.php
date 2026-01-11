@extends('layouts.app')
@section('title', 'Booking Saya')

@section('content')
<div class="py-12 bg-gray-50 min-h-screen">
    <div class="max-w-4xl mx-auto px-4">
        
        <div class="mb-8">
            <h1 class="text-3xl font-medium text-gray-900 mb-2">Booking Saya</h1>
            <p class="text-gray-600">Riwayat semua booking Anda.</p>
        </div>

        @forelse($bookings as $booking)
        <div class="bg-white border border-gray-200 rounded-lg p-5 sm:p-6 mb-4 hover:border-gray-300 transition">
            <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                
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
                    
                    <div class="flex flex-wrap gap-4 text-sm text-gray-700 mb-3">
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

                    {{-- Review Display --}}
                    @if($booking->review)
                    <div class="mt-3 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                        <div class="flex items-center gap-2 mb-2">
                            <div class="flex">
                                @for($i = 1; $i <= 5; $i++)
                                <svg class="w-4 h-4 {{ $i <= $booking->review->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                @endfor
                            </div>
                            <span class="text-sm font-medium text-gray-900">Your Review</span>
                        </div>
                        @if($booking->review->comment)
                        <p class="text-sm text-gray-700">{{ $booking->review->comment }}</p>
                        @endif
                    </div>
                    @endif
                </div>

                <div class="flex flex-row sm:flex-col items-center sm:items-end gap-3">
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
                    
                    @if($booking->service->price ?? null)
                    <p class="text-lg font-semibold text-gray-900">Rp {{ number_format($booking->service->price, 0, ',', '.') }}</p>
                    @endif
                    
                    @if($status === 'pending')
                    <form method="POST" action="{{ route('bookings.cancel', $booking->id) }}" onsubmit="return confirm('Yakin batalkan?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-xs text-red-600 hover:text-red-800 underline">
                            Batalkan
                        </button>
                    </form>
                    @endif

                    {{-- Review Button --}}
                    @if($booking->canBeReviewed())
                    <button onclick="openReviewModal({{ $booking->id }})" class="px-4 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700 transition">
                        Beri Review
                    </button>
                    @endif
                </div>
            </div>
        </div>
        @empty
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

{{-- Review Modal --}}
<div id="reviewModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-xl max-w-md w-full p-6">
        <h3 class="text-xl font-semibold text-gray-900 mb-4">Beri Review</h3>
        <form id="reviewForm" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Rating</label>
                <div class="flex gap-2">
                    @for($i = 1; $i <= 5; $i++)
                    <button type="button" onclick="setRating({{ $i }})" class="rating-btn w-12 h-12 border-2 border-gray-300 rounded-lg hover:border-yellow-400 hover:bg-yellow-50 transition">
                        <svg class="w-6 h-6 mx-auto text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    </button>
                    @endfor
                </div>
                <input type="hidden" name="rating" id="ratingInput" required>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Comment (Optional)</label>
                <textarea name="comment" rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
            </div>
            <div class="flex gap-3">
                <button type="submit" class="flex-1 px-4 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                    Submit Review
                </button>
                <button type="button" onclick="closeReviewModal()" class="px-4 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-medium">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>

<script>
let selectedRating = 0;

function openReviewModal(bookingId) {
    document.getElementById('reviewModal').classList.remove('hidden');
    document.getElementById('reviewForm').action = `/bookings/${bookingId}/review`;
    selectedRating = 0;
    updateRatingDisplay();
}

function closeReviewModal() {
    document.getElementById('reviewModal').classList.add('hidden');
    document.getElementById('reviewForm').reset();
}

function setRating(rating) {
    selectedRating = rating;
    document.getElementById('ratingInput').value = rating;
    updateRatingDisplay();
}

function updateRatingDisplay() {
    const buttons = document.querySelectorAll('.rating-btn');
    buttons.forEach((btn, index) => {
        const svg = btn.querySelector('svg');
        if (index < selectedRating) {
            btn.classList.add('border-yellow-400', 'bg-yellow-50');
            btn.classList.remove('border-gray-300');
            svg.classList.add('text-yellow-400');
            svg.classList.remove('text-gray-300');
        } else {
            btn.classList.remove('border-yellow-400', 'bg-yellow-50');
            btn.classList.add('border-gray-300');
            svg.classList.remove('text-yellow-400');
            svg.classList.add('text-gray-300');
        }
    });
}
</script>
@endsection
