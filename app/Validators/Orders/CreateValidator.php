<?php

namespace App\Validators\Orders;

use App\Validators\AbstractValidator;

class CreateValidator extends AbstractValidator
{
    protected $rules = [
        'default' => [
            'product_id' => 'required|exists:products,id',
            'qry' => 'required|integer',
        ],
    ];
}