<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    public function show()
    {
        return view('login/login');
    }

    public function verification(Request $request) 
    {
        $response = ['status' => 'fail', 'msg' => ''];
        $rules = ['captcha' => 'required|captcha'];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $response['msg'] = 'captcha verification failed';
        } else{
            $user = User::where('user_number', $request->input('user_number'))->first();

            if (! empty($user)) {
                if (Hash::check($request->input('user_password'), $user->user_password)) {
                    session(['user_number' => $user->user_number]);
                    $response['status'] = 'OK';

                    $user->update(
                        ['login_time' => date('Y/m/d H:i:s')],
                        ['sign_out_time' => date('Y/m/d H:i:s')]
                    );
                } else {
                    $response['msg'] = 'password is incorrect';
                    session()->flush();
                }
            } else {
                $response['msg'] = 'no user found';
                session()->flush();
            }
        }

        echo json_encode($response);
    }

    public function logout()
    {
        session()->flush();

        return redirect('/login');
    }
}
