<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Book extends Model
{
    protected $fillable = ['author_id','category_id', 'publisher_id', 'title', 'price','publish_date', 'count','available'];
    // Add the relationships:

    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    public function publisher(): BelongsTo
    {
        return $this->belongsTo(Publisher::class);
    }
    // Relationship to Orders via OrderItem (pivot table)
    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'order_items')
            ->withTimestamps();
    }


}
