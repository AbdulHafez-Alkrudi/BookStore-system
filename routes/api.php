<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->group(function () {
    Route::post('/order',  [\App\Http\Controllers\OrderController::class, 'store']);

});
require __DIR__.'/auth.php';
