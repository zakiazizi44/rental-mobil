<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'brand',
        'model',
        'year',
        'license_plate',
        'price_per_day',
        'capacity',
        'transmission',
        'fuel_type',
        'color',
        'description',
        'facilities',
        'image',
        'status',
    ];

    protected $casts = [
        'price_per_day' => 'decimal:0',
        'year' => 'integer',
    ];

    /**
     * Relasi: mobil dimiliki oleh satu kategori.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relasi: satu mobil memiliki banyak booking.
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Ambil URL gambar mobil. Jika tidak ada, gunakan placeholder.
     */
    public function getImageUrlAttribute(): string
    {
        if ($this->image && file_exists(public_path('storage/' . $this->image))) {
            return asset('storage/' . $this->image);
        }
        return asset('images/car-placeholder.svg');
    }

    /**
     * Label status mobil dalam Bahasa Indonesia.
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'available'  => 'Tersedia',
            'rented'     => 'Disewa',
            'maintenance'=> 'Maintenance',
            default      => $this->status,
        };
    }
}
