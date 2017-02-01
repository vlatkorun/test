<?php

namespace App\Repositories\Ordering\Common;

use Prettus\Repository\Contracts\RepositoryInterface;
use App\Repositories\Ordering\Direction;
use App\Repositories\Ordering\OrderingInterface;

class UpdatedAtAscending implements OrderingInterface
{
    public function apply($model, RepositoryInterface $repository)
    {
        return $model->orderBy('updated_at', Direction::ASC);
    }
}