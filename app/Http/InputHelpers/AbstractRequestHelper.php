<?php

namespace App\Http\InputHelpers;

use Illuminate\Http\Request;

abstract class AbstractRequestHelper
{
    protected $params = [];
    protected $request;

    public function before(Request $request)
    {
        return $request;
    }

    public function extract(Request $request)
    {
        $this->request = $this->before($request);

        foreach($request->all() as $param => $value)
        {
            $method = sprintf('set%sParam', studly_case($param));

            if(method_exists($this, $method))
            {
                $this->params = call_user_func_array([$this, $method], [$value, $this->params]);
            }
        }

        return $this->after($this->params);
    }

    public function after(array $params)
    {
        return $params;
    }
}