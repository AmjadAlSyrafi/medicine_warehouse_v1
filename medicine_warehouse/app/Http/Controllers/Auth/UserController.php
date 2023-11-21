<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;
class UserController extends Controller
{
    public function createUser(Request $request) : JsonResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'numeric', 'digits:10' , 'unique:'.User::class],
            'role' => ['required', Rule::in(['Admin' , 'Pharmacy' , 'admin' , 'pharmacy'])],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        $user->role = $request->role;

         $user->save();

        event(new Registered($user));

        Auth::login($user);

        $token = $user->createToken('api-token')->plainTextToken;

        $user ->save();
        return response()->json([
            'status' => true,
            'message' => 'User Created Successfully',
            'user'=> $user,
            'token' => $token,
            ]);
    }

    /**
     * Login The User
     * @param Request $request
     * @return User
     */
    public function loginUser(Request $request)
    {

      if(!Auth::attempt($request->only(['phone_number', 'password','role']))){
        return response()->json([
            'status' => false,
            'message' => 'Phone & Password does not match',
        ], 401);
    }

    $user = User::where('phone_number', $request->phone_number)->first();

    $user->tokens()->delete();

    return response()->json([
        'status' => true,
        'message' => 'User Logged In Successfully',
        'user' => $user,
        'token' => $user->createToken("API TOKEN")->plainTextToken
    ], 200);

    }

    public function logoutUser(Request $request): JsonResponse
    {
    // Check if the user is authenticated
    if (!Auth::check()) {
        return response()->json([
            'status' => false,
            'message' => 'User is not authenticated',
        ], 401);
        // If authenticated, delete the current access token
    } else {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => true,
            'message' => 'User Logged Out Successfully',
        ]);
    }
    }
}

