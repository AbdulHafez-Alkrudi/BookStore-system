<?php

namespace App\Http\Controllers;

use App\Models\Order;
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
            'type' => ['required' , 'in:borrow,buy'],
            'items' => ['array', 'present'],
            'items.*.book_id' => ['required' , 'exists:books,id'],
            'items.*.amount' => ['required'],
            'items.*.unit_price' => ['required']
        ]);

        if($validator->failed()){
            return $this->errorResponse($validator->errors());
        }
        $total_invoice = 0 ;
        $books = $request['items'];
        foreach($books as $book){
            $total_invoice += $book->amount * $book->unit_price ;
        }
        $order = Order::create([
            'user_id' => auth()->user()->id(),
            'total_invoice' => $total_invoice,
            'type' => $request['type']
        ]);

    }
}
