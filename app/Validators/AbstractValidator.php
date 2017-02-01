<?php

namespace App\Validators;

use Crhayes\Validation\ContextualValidator;

class AbstractValidator extends ContextualValidator
{
    public function __construct($attributes = null, $context = null)
    {
        $this->init();

        parent::__construct($attributes, $context);
    }

    protected function init()
    {}
}