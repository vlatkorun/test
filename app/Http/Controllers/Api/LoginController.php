<?php

namespace App\Http\Controllers\Api;

use Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);

        $token = Auth::guard('api')->attempt($credentials);

        if(!$token)
        {
            return $this->error('Wrong username or password!');
        }

        return $this->success('Login success!', ['token' => $token]);
    }

    public function logout(Request $request)
    {
        Auth::guard('api')->logout();
        return $this->success('You have logout');
    }
}