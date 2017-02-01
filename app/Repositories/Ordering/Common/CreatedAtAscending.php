<?php

namespace App\Repositories\Ordering\Common;

use Prettus\Repository\Contracts\RepositoryInterface;
use App\Repositories\Ordering\Direction;
use App\Repositories\Ordering\OrderingInterface;

class CreatedAtAscending implements OrderingInterface
{
    public function apply($model, RepositoryInterface $repository)
    {
        return $model->orderBy('created_at', Direction::ASC);
    }
}