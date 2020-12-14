<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $user = $request->user();

        if($user){
            return response([
                'response_code' => '00',
                'response_message' => 'User Berhasil Ditampilkan',
                'data' => [
                    'profile' => $user
                ]
            ]);
        }else{
            return response([
                'response_code' => '05',
                'response_message' => 'Maaf Anda Belum Login',
            ]);
        }
        
    }
}
