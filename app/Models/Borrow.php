<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Borrow extends Model
{
    protected $fillable = ['order_item_id','user_id', 'due_date','returned_at', 'status'];
    protected $casts = [
        'due_date' => 'datetime',
        'returned_at' => 'datetime',
    ];

    public function orderItem(): BelongsTo
    {
        return $this->belongsTo(OrderItem::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function book(): HasOneThrough
    {
        return $this->hasOneThrough(
            Book::class,
            OrderItem::class,
            'id', // Foreign key on order_items table
            'id', // Foreign key on books table
            'order_item_id', // Local key on borrows table
            'book_id' // Local key on order_items table
        );
    }

    // Helper method to check overdue status
    public function isOverdue(): bool
    {
        return $this->due_date->isPast() && $this->status === 'active';
    }
}
