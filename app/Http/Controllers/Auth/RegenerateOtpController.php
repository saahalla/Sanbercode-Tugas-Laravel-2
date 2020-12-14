<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\OtpCode;
use Carbon\Carbon;

class RegenerateOtpController extends Controller
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
        ]);
        $user = User::where('email', $request->email)->first();

        $otp = rand(100000,999999);
        $current = Carbon::now();
        $valid_until = $current->addMinutes(5);

        if($user->email_verified_at == null){
            //regenerate otp
            OtpCode::where('user_id', $user->id)
                            ->update([
                                'otp' => $otp,
                                'valid_until' => $valid_until
                            ]);
            $response = [
                'response_code' => '00',
                'response_message' => 'silakan cek email',
                'data' => $user
            ];
        }else{
            $response = [
                'response_code' => '02',
                'response_message' => 'Email Anda suda terverivikasi, Anda sudah tidak perlu meregenerate OTP lagi, silakan Ubah password',
            ];
        }
        return response($response);
    }
}
