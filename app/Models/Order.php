<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = ['user_id'];

    // Define the relationship with User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Then keep your current belongsToMany relationships but add:
    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class, 'order_items')
            ->withPivot('quantity') // Add this
            ->withTimestamps();
    }
}
