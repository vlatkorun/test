<?php

namespace App\Http\InputHelpers\Orders;

use App\Http\InputHelpers\AbstractRequestHelper;
use Illuminate\Http\Request;

class Create extends AbstractRequestHelper
{
    protected function setProductParam($value, $input)
    {
        $value = (int) trim($value);

        if($value > 0)
        {
            $input['product'] = $value;
        }

        return $input;
    }

    protected function setQtyParam($value, $input)
    {
        $value = (int) trim($value);

        if($value > 0)
        {
            $input['qty'] = $value;
        }

        return $input;
    }

    public function after(array $input)
    {
        if(!empty($input['product']))
        {
            $input['product_id'] = $input['product'];
        }

        return $input;
    }
}