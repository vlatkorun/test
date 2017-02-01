<?php

namespace App\Repositories\Criteria\Products;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;
use App\Repositories\Criteria\NeedsSearchValueInterface;

class PriceBetween implements CriteriaInterface, NeedsSearchValueInterface
{
    protected $between = [];

    public function __construct($value)
    {
        $this->setValue($value);
    }

    public function setValue($value)
    {
        if(is_string($value))
        {
            $value = explode(",", trim($value));
        }

        if(is_array($value) && count($value) === 2)
        {
            $this->between = array_map(function($item) {return (int) trim($item);}, $value);
        }
    }

    public function apply($model, RepositoryInterface $repository)
    {
        if(!empty($this->between))
        {
            $model->whereBetween('price', $this->between);
        }
        return $model;
    }
}