<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    // Define the relationship with Order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
