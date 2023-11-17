<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    # Method register - untuk register authentication
    public function register(Request $request)
    {    
        if ($request->name AND $request->email AND $request->email AND $request->password) {
            # Menangkap inputan
            $input = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ];

            # Insert data ke table user
            $user = User::create($input);
        
            $data = [
                'message' => 'User is created successfully'
            ];

            # Mingirim reponse JSON
            return response()->json($data, 200);
        } else {
            $data = [
                'message' => 'User is add failed',
            ];

            # Mengembalikan data (json) dan kode 404
            return response()->json($data, 404);
        }
    }

    # Method login - untuk mengambil token
    public function login(Request $request)
    {
        # Menangkap input user
        $input = [
            'email' => $request->email,
            'password' => $request->password
        ];

        # Melakukan autentikasi
        if (Auth::attempt($input)) {
            # Membuat token
            $token = Auth::user()->createToken('auth_token');

            $data = [
                'message' => 'Login Successfuly',
                'token' => $token->plainTextToken
            ];

            # Mengembalikan response JSON
            return response()->json($data, 200);
        } else {
            $data = [
                'message' => 'Username or Password is wrong'
            ];

            # Mengembalikan response JSON
            return response()->json($data, 401); 
        }
    }
}