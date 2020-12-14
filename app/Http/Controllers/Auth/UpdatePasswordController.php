<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

class UpdatePasswordController extends Controller
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
            'password_confirmation' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();
        
        if($request->password != $request->password_confirmation){
            return response([
                'response_code' => '04',
                'response_message' => 'Maaf Password dan Password Confirmation Anda tidak sesuai, Silakan Coba masukkan password yang sama.',
            ]);
        }

        if(!$user){
            $response = [
                'response_code' => '02',
                'response_message' => 'Maaf Email Anda Salah, Silakan Masukkan email yang terdaftar.',
            ];
        }else{
            if($user->email_verified_at != null){
                // jalankan update password
                User::where('id', $user->id)
                            ->update([
                                'password' => bcrypt($request->password),
                            ]);

                $response = [
                    'response_code' => '00',
                    'response_message' => 'Password Berhasil Diubah',
                    'data' => $user
                ];

            }else{
                // respon user belum terverifikasi
                $response = [
                    'response_code' => '03',
                    'response_message' => 'Maaf User Anda belum terverifikasi, silakan verifikasi OTP user Anda terlebih dahulu.',
                ];
            }
            
        }
        return response($response);
    }
}
