<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

   protected $fillable = [
    'user_id',
    'driver_id',
    'full_name',
    'phone',
    'address',
    'barangay',
    'city',
    'postal_code',
    'delivery_notes',
    'subtotal',
    'delivery_fee',
    'total',
    'payment_method',
    'payment_status',
    'status',
    'cancellation_reason',
    'cancelled_by',
    'cancelled_at',
    'driver_assigned_at',
];

    protected function casts(): array
    {
        return [
            'subtotal' => 'decimal:2',
            'delivery_fee' => 'decimal:2',
            'total' => 'decimal:2',
            'cancelled_at' => 'datetime',
            'driver_assigned_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function driver(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'driver_id'
        );
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}