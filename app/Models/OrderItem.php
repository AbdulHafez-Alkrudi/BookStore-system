<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class OrderItem extends Model
{
    protected $fillable = ['order_id', 'book_id', 'amount','unit_price','type'];
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    // Add this relationship
    public function borrow(): HasOne
    {
        return $this->hasOne(Borrow::class);
    }

    // Helper method to check borrow type
    public function isBorrow(): bool
    {
        return $this->type === 'borrow';
    }

    // In OrderItem model
    protected static function booted()
    {
        static::created(function (OrderItem $orderItem) {
            if ($orderItem->type === 'borrow') {
                Borrow::create([
                    'order_item_id' => $orderItem->id,
                    'user_id' => $orderItem->order->user_id, // Get user from order
                    'due_date' => now()->addDays(14), // Example: 14-day borrow period
                    'status' => 'active',
                ]);
            }
        });
    }
}
