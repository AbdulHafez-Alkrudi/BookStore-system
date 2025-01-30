<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderItemController extends Controller
{
    use ApiResponseTrait;

    public function index()
    {
        return OrderItem::with(['order', 'book'])->get();
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:orders,id',
            'book_id' => 'required|exists:books,id',
            'quantity' => 'required|integer|min:1',
            // Add other fields as needed
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors());
        }

        $orderItem = OrderItem::create([
            'order_id' => $request->order_id,
            'book_id' => $request->book_id,
            'quantity' => $request->quantity,
            // Add other fields as needed
        ]);

        return $this->successResponse($orderItem, 'Order item created successfully');
    }

    public function destroy(OrderItem $orderItem)
    {
        $orderItem->delete();
        return $this->successResponse(null, 'Order item deleted successfully');
    }
}
