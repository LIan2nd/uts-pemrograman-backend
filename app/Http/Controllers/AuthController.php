<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    // Register Method
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255|min:3',
            'email' => 'required|email',
        ]);

        $validatedData['password'] = Hash::make($request->password);

        $user = User::create($validatedData);

        $data = [
            'message' => 'User is created successfully'
        ];

        return response()->json($data, 200);
    }

    // Login Method
    public function login(Request $request)
    {
        $input = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (!Auth::attempt($input)) {
            $data = [
                'message' => 'Email or Password is wrong'
            ];

            return response()->json($data, 401);
        }

        $token = Auth::user()->createToken('auth_token');

        $data = [
            'message' => 'Login Successfully',
            'token' => $token->plainTextToken
        ];

        return response()->json($data, 200);
    }
}