<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'payment_method',
        'amount',
        'payment_proof',
        'transaction_id',
        'payment_type',
        'snap_token',
        'status',
        'paid_at',
        'verified_at',
    ];

    protected $casts = [
        'amount'      => 'decimal:0',
        'paid_at'     => 'datetime',
        'verified_at' => 'datetime',
    ];

    /**
     * Relasi: payment dimiliki oleh satu booking.
     */
    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    /**
     * URL bukti pembayaran.
     */
    public function getProofUrlAttribute(): string
    {
        if ($this->payment_proof && file_exists(public_path('storage/' . $this->payment_proof))) {
            return asset('storage/' . $this->payment_proof);
        }
        return asset('images/payment-placeholder.svg');
    }

    /**
     * Label status payment.
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending'  => 'Pending',
            'verified' => 'Verified',
            'rejected' => 'Rejected',
            default    => $this->status,
        };
    }
}
