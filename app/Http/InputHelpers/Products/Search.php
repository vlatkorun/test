<?php

namespace App\Http\InputHelpers\Products;

use App\Http\InputHelpers\AbstractRequestHelper;

class Search extends AbstractRequestHelper
{
    protected function setPriceFromParam($value, $input)
    {
        $value = (int) trim($value);

        if($value > 0)
        {
            $input['price_from'] = $value;
        }

        return $input;
    }

    protected function setPriceToParam($value, $input)
    {
        $value = (int) trim($value);

        if($value > 0)
        {
            $input['price_to'] = $value;
        }

        return $input;
    }

    protected function setNameParam($value, $input)
    {
        $value = trim($value);

        if(!empty($value))
        {
            $input['name'] = $value;
        }

        return $input;
    }

    public function after(array $input)
    {
        if(!empty($input['price_from']) && !empty($input['price_to']))
        {
            $input['price_between'] = [$input['price_from'], $input['price_to']];
        }

        return $input;
    }
}