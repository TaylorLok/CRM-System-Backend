<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Log;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string|min:8'
        ]);
       
        Log::info(json_encode($request->all()));

        $credentials = $request->only('email', 'password');
       
        if(Auth::attempt($credentials))
        {
            return response()->json(['message' => 'Login Successful','user' => Auth::user()], 200);
        }

        return response()->json(['error' => 'Invalid Credentials, please check your email or password'], 401);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        return response()->json(['message' => 'Successful Logged out'], 200);
    }
}
