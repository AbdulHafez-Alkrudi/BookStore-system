<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthorController extends Controller
{
    use ApiResponseTrait;

    public function index()
    {
        return Author::all();
    }
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if($validator->failed()){
            return $this->errorResponse($validator->errors());
        }
        $author = Author::create([
            'name' => $request->name
        ]);
        return $this->successResponse($author);
    }

    public function destroy(Author $author)
    {
        $author->delete();
        return $this->successResponse();
    }
}
