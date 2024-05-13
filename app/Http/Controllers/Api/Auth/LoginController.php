<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use  App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(LoginRequest $request)
    {
      $user = User::where('email', $request->email)->first();   
      if(!$user || !Hash::check($request->password,$user->password)){
            throw ValidationException::withMessages([
                'email' =>['Invalid email']
            ]);
      }
      return response()->json([
       'user'=>$user,
       'token' => $user->createToken('laravel_api_token')->plainTextToken
      ]);
      // if(!auth()->attempt($request->only(['email','password']))){
      //   throw ValidationException::withMessages([
      //       'email' =>['Invalid email']
      //   ]);
      //}
    }
}
