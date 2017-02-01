<?php

namespace App\Http\Controllers\Api;

use Auth;

class ProfileController extends Controller
{
    public function profile()
    {
        return response()->json(Auth::user());
    }
}