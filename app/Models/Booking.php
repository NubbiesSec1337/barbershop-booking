<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Booking extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'service_id',
        'barber_id',
        'booking_date',
        'booking_time',
        'status',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'booking_date' => 'date',
        'booking_time' => 'datetime',
    ];

    /**
     * Relationship: Booking belongs to user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship: Booking belongs to service
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Relationship: Booking belongs to barber
     */
    public function barber()
    {
        return $this->belongsTo(Barber::class);
    }

    /**
     * Relationship: Booking has one review
     */
    public function review()
    {
        return $this->hasOne(Review::class);
    }

    /**
     * Check if booking can be reviewed
     */
    public function canBeReviewed(): bool
    {
        return $this->status === 'completed' && !$this->review;
    }

    /**
     * Check if booking can be cancelled
     */
    public function canBeCancelled(): bool
    {
        return in_array($this->status, ['pending', 'confirmed']) 
            && $this->booking_date->isFuture();
    }

    /**
     * Check if booking is upcoming (future date & pending/confirmed)
     */
    public function isUpcoming(): bool
    {
        return $this->booking_date->isFuture() 
            && in_array($this->status, ['pending', 'confirmed']);
    }

    /**
     * Check if booking is past
     */
    public function isPast(): bool
    {
        return $this->booking_date->isPast();
    }

    /**
     * Get booking datetime combined
     */
    public function getFullDatetimeAttribute(): Carbon
    {
        return Carbon::parse($this->booking_date->format('Y-m-d') . ' ' . $this->booking_time->format('H:i:s'));
    }

    /**
     * Get booking status badge color
     */
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'pending' => 'yellow',
            'confirmed' => 'green',
            'completed' => 'blue',
            'cancelled' => 'red',
            default => 'gray',
        };
    }

    /**
     * Get booking status label
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'pending' => 'Pending',
            'confirmed' => 'Confirmed',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled',
            default => 'Unknown',
        };
    }

    /**
     * Scope: Only upcoming bookings
     */
    public function scopeUpcoming($query)
    {
        return $query->where('booking_date', '>=', now())
            ->whereIn('status', ['pending', 'confirmed']);
    }

    /**
     * Scope: Only past bookings
     */
    public function scopePast($query)
    {
        return $query->where('booking_date', '<', now());
    }

    /**
     * Scope: Only completed bookings
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope: Only pending bookings
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope: Filter by date
     */
    public function scopeForDate($query, $date)
    {
        return $query->whereDate('booking_date', $date);
    }

    /**
     * Scope: Filter by barber
     */
    public function scopeForBarber($query, $barberId)
    {
        return $query->where('barber_id', $barberId);
    }

    /**
     * Scope: Filter by user
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Mark booking as confirmed
     */
    public function confirm(): bool
    {
        return $this->update(['status' => 'confirmed']);
    }

    /**
     * Mark booking as completed
     */
    public function complete(): bool
    {
        return $this->update(['status' => 'completed']);
    }

    /**
     * Mark booking as cancelled
     */
    public function cancel(): bool
    {
        return $this->update(['status' => 'cancelled']);
    }

    /**
     * Get formatted booking time (HH:MM)
     */
    public function getFormattedTimeAttribute(): string
    {
        return Carbon::parse($this->booking_time)->format('H:i');
    }

    /**
     * Get formatted booking date (d M Y)
     */
    public function getFormattedDateAttribute(): string
    {
        return $this->booking_date->format('d M Y');
    }

    /**
     * Get total price from service
     */
    public function getTotalPriceAttribute()
    {
        return $this->service ? $this->service->price : 0;
    }

    /**
     * Check if booking has review
     */
    public function hasReview(): bool
    {
        return $this->review !== null;
    }
}
