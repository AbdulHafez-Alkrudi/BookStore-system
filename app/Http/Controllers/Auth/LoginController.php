<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\ApiResponseTrait;

class LoginController extends Controller
{
    use ApiResponseTrait;

    /**
     * Handle an incoming authentication request.
     */
    public function login(LoginRequest $request)
    {
        // Attempt authentication
        if (!Auth::attempt($request->validated())) {
            return $this->errorResponse('Invalid credentials', 401);
        }

        $user = Auth::user();
        // Revoke existing tokens (optional)
        $user->tokens()->delete();

        // Create new API token
        $user['token'] = $user->createToken('api-token')->plainTextToken;
        return $this->successResponse($user);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request)
    {
        // Revoke current user's token
        $request->user()->currentAccessToken()->delete();

        return $this->successResponse(null, 'Successfully logged out');
    }
}
