<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barber extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'bio',
        'max_slots_per_time',
        'is_active',
        'photo',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
        'max_slots_per_time' => 'integer',
    ];

    /**
     * Relationship: Barber has many bookings
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Relationship: Barber has many reviews
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Relationship: Barber is favourited by many users (many-to-many)
     */
    public function favouritedBy()
    {
        return $this->belongsToMany(User::class, 'favourite_barbers', 'barber_id', 'user_id')
            ->withTimestamps();
    }

    /**
     * Get average rating
     */
    public function averageRating()
    {
        $avg = $this->reviews()->avg('rating');
        return $avg ? round($avg, 1) : 0;
    }

    /**
     * Get total reviews count
     */
    public function totalReviews(): int
    {
        return $this->reviews()->count();
    }

    /**
     * Get rating distribution (1-5 stars count)
     */
    public function ratingDistribution(): array
    {
        $distribution = [];
        for ($i = 1; $i <= 5; $i++) {
            $distribution[$i] = $this->reviews()->where('rating', $i)->count();
        }
        return $distribution;
    }

    /**
     * Get bookings count for specific date
     */
    public function getBookingsCountForDate($date): int
    {
        return $this->bookings()
            ->whereDate('booking_date', $date)
            ->count();
    }

    /**
     * Check if barber is available for booking (not full)
     */
    public function isAvailableForDate($date): bool
    {
        $bookingsCount = $this->getBookingsCountForDate($date);
        return $bookingsCount < $this->max_slots_per_time && $this->is_active;
    }

    /**
     * Get total revenue (sum of all completed bookings)
     */
    public function getTotalRevenueAttribute()
    {
        return $this->bookings()
            ->where('status', 'completed')
            ->whereHas('service')
            ->with('service')
            ->get()
            ->sum(function($booking) {
                return $booking->service->price ?? 0;
            });
    }

    /**
     * Get completed bookings count
     */
    public function getCompletedBookingsAttribute(): int
    {
        return $this->bookings()->where('status', 'completed')->count();
    }

    /**
     * Get pending bookings count
     */
    public function getPendingBookingsAttribute(): int
    {
        return $this->bookings()->where('status', 'pending')->count();
    }

    /**
     * Scope: Only active barbers
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Accessor: Get photo URL
     */
    public function getPhotoUrlAttribute(): ?string
    {
        if ($this->photo) {
            return asset('storage/' . $this->photo);
        }
        return null;
    }

    /**
     * Get latest reviews
     */
    public function latestReviews($limit = 5)
    {
        return $this->reviews()
            ->with('user')
            ->latest()
            ->take($limit)
            ->get();
    }
}
