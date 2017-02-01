<?php

namespace App\Http\Middleware\Handlers;

use Illuminate\Http\Request;

class Factory
{
    public function make(Request $request)
    {
        if($request->format() == 'json' || $request->isJson() || $request->wantsJson())
        {
            return new Json;
        }

        return new Html;
    }
}