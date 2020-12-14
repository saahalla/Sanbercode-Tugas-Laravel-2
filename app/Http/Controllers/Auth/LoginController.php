<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        if(!$token = auth()->attempt($request->only('email', 'password'))){
            return response([
                'response_code' => '02',
                'response_message' => 'Maaf User Anda belum terdaftar, silakan mendaftar terlebih dahulu',
            ], 401);
        }
        // data user
        $user = User::where('email', $request->email)->first();

        return response([
            'response_code' => '00',
            'response_message' => 'User Berhasil Login',
            'data' => [
                'token' => $token,
                'user' => $user
            ]
        ]);

    }
}
