<?php

namespace App\Repositories;

use App\Models\Product;
use App\Presenters\ProductPresenter;
use App\Repositories\Ordering\Direction as OrderingDirection;
use App\Repositories\Ordering\Common\CreatedAtAscending;
use App\Repositories\Ordering\Common\CreatedAtDescending;
use App\Repositories\Ordering\Common\UpdatedAtAscending;
use App\Repositories\Ordering\Common\UpdatedAtDescending;
use App\Repositories\Criteria\Products\Price;
use App\Repositories\Criteria\Products\PriceBetween;
use App\Repositories\Criteria\Products\Name;

class ProductsRepository extends BaseRepository
{
    protected $skipPresenter = true;

    protected $searchFields = [
        'name' => Name::class,
        'price' => Price::class,
        'price_between' => PriceBetween::class,
    ];

    protected $orderFields = [
        'created_at' => [
            OrderingDirection::ASC => CreatedAtAscending::class,
            OrderingDirection::DESC => CreatedAtDescending::class
        ],
        'updated_at'=> [
            OrderingDirection::ASC => UpdatedAtAscending::class,
            OrderingDirection::DESC => UpdatedAtDescending::class
        ],
    ];

    public function model()
    {
        return Product::class;
    }

    public function presenter()
    {
        return ProductPresenter::class;
    }
}