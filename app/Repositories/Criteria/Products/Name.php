<?php

namespace App\Repositories\Criteria\Products;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;
use App\Repositories\Criteria\NeedsSearchValueInterface;

class Name implements CriteriaInterface, NeedsSearchValueInterface
{
    protected $value;

    public function __construct($value)
    {
        $this->setValue($value);
    }

    public function setValue($value)
    {
        $value = trim($value);

        if(!empty($value))
        {
            $this->value = $value;
        }
    }

    public function apply($model, RepositoryInterface $repository)
    {
        if(!is_null($this->value))
        {
            $model = $model->where('name', 'LIKE', '%' . $this->value . '%');
        }
        return $model;
    }
}