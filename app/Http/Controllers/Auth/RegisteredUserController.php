<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ApiResponseTrait;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;

class RegisteredUserController extends Controller
{

    use ApiResponseTrait ;
    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'gender' => ['required' , 'in:male,female'],
            'phone' => ['required', 'size:10'],
            'image' => ['required', 'image' , 'mimes:jpeg,png,bmp,jpg,svg']
        ] ,
        [
            'gender.in:' => 'The selected gender is invalid.',
        ]);

        // To store the image:

        $image= $request->file('image');
        if($request->hasFile('image')){
            // Changing the name of the image to guarantee that the names are all unique
            $user_image = time().'.'.$image->getClientOriginalExtension();

            // Moving the image to public/image
            $image->move(public_path('image') , $user_image);

            // storing the image path
            $user_image= 'image/'.$user_image ;
        }


        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->string('password')),
            'image' => $user_image,
            'phone' => $request->phone,
            'gender' => $request->gender,
        ]);

        //event(new Registered($user));

//        Auth::login($user);
        return $this->successResponse($user);
    }
}
