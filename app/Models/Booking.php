<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_code',
        'user_id',
        'car_id',
        'phone',
        'start_date',
        'end_date',
        'total_days',
        'price_per_day',
        'total_price',
        'status',
        'notes',
    ];

    protected $casts = [
        'start_date'  => 'date',
        'end_date'    => 'date',
        'price_per_day' => 'decimal:0',
        'total_price' => 'decimal:0',
    ];

    /**
     * Relasi: booking dimiliki oleh satu user.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi: booking dimiliki oleh satu mobil.
     */
    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }

    /**
     * Relasi: satu booking memiliki satu pembayaran.
     */
    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    /**
     * Label status booking dalam Bahasa Indonesia.
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending'              => 'Pending',
            'waiting_payment'      => 'Menunggu Pembayaran',
            'payment_verification' => 'Menunggu Verifikasi',
            'confirmed'            => 'Confirmed',
            'ongoing'              => 'Berlangsung',
            'completed'            => 'Selesai',
            'cancelled'            => 'Dibatalkan',
            default                => $this->status,
        };
    }
}
