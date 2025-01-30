<?php

namespace App\Http\Controllers;

use App\Models\Borrow;
use App\Models\Order;
use App\Models\OrderItem;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    use ApiResponseTrait;

    public function store(Request $request){
        DB::beginTransaction();
        $validator = Validator::make($request->all(), [
            'items' => ['array', 'present'],
            'items.*.book_id' => ['required', 'exists:books,id'],
            'items.*.amount' => ['required'],
            'items.*.unit_price' => ['required'],
            'items.*.type' => ['required', 'in:buy,borrow'],
            'items.*.due_date' => ['required_if:items.*.type,borrow','date'],
        ]);
        if($validator->fails()){
            DB::rollBack();
            return $this->errorResponse($validator->errors());
        }
        $total_invoice = 0 ;
        $books = $request['items'];
        foreach($books as $book){
            $total_invoice += $book['amount'] * $book['unit_price'] ;
        }
        $order = Order::create([
            'user_id' => auth()->user()->id,
            'total_invoice' => $total_invoice,
        ]);
        foreach($books as $book){
            OrderItem::create([
                'order_id' => $order->id,
                'book_id' => $book['book_id'],
                'amount' => $book['amount'],
                'unit_price' => $book['unit_price'],
                'type' => $book['type']
            ]);
        }
        DB::commit();
        return $this->successResponse($order);
    }
}
