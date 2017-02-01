<?php

namespace App\Repositories\Ordering;

use Prettus\Repository\Contracts\RepositoryInterface;

interface OrderingInterface
{
    public function apply($model, RepositoryInterface $repository);
}