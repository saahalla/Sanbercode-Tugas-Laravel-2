<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use App\OtpCode;
use App\Http\Requests\Auth\RegisterRequest;
use Carbon\Carbon;

class RegisterController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(RegisterRequest $request)
    {
        
        $register = User::create([
            'name' => request('name'),
            'email' => request('email')
        ]);
        
        $id = $register['id'];
        $otp = rand(100000,999999);
        $current = Carbon::now();
        $valid_until = $current->addMinutes(5);

        OtpCode::create([
            'user_id' => $id,
            'otp' => $otp,
            'valid_until' => $valid_until
        ]);

        return response([
            'response_code' => '00',
            'response_message' => 'silakan cek email',
            'data' => $register
        ]);
    }
} 
