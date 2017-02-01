<?php

namespace App\Http\Middleware;

use Closure;
use JavaScript;

class JSParams
{
    public function handle($request, Closure $next)
    {
        $configuration = config('frontend');
        
        unset($configuration['protected']);

        $configuration = array_change_key_case($configuration, CASE_UPPER);

        foreach($configuration as $key => $value)
        {
            if(!is_array($value))
            {
                continue;
            }

            $configuration[$key] = array_change_key_case($value, CASE_UPPER);
        }

        JavaScript::put($configuration);

        return $next($request);
    }
}