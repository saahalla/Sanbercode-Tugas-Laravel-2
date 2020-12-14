<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\OtpCode;
use App\User;
use DB;
use Carbon\Carbon;

class VerificationController extends Controller
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
            'otp' => 'required',
        ]);
        $otp = OtpCode::where('otp', $request->otp)->first();
        if(!$otp){
            return response([
                'response_code' => '01',
                'response_message' => 'Code Otp Anda tidak tepat, silakan masukkan code otp yang benar.'
            ]);
        }

        $now = Carbon::now();
        $valid_until = $otp->valid_until;
        $user = User::where('id', $otp->user_id)->first();
        
        if($now > $valid_until){
            return response([
                'response_code' => '01',
                'response_message' => 'Code Otp Anda sudah kadaluarsa, silakan Generate Ulang kode OTP'
            ]);
        }else{
            $email_verified = User::where('email', $user->email)
                                ->update(['email_verified_at' => $now]);
            
            OtpCode::destroy($otp->id);

            return response([
                'response_code' => '00',
                'response_message' => 'Berhasil di Verifikasi, Silakan Ubah Password Anda',
                'data' => $user
            ]);
        }


        // 
        
    }
}
