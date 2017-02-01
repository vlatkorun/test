<?php

namespace App\Repositories\Criteria\Common;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;
use App\Repositories\Criteria\NeedsSearchValueInterface;
use \DateTime;

class UpdatedAt implements CriteriaInterface, NeedsSearchValueInterface
{
    protected $dateFrom;
    protected $dateTo;

    public function __construct($date)
    {
        $this->setValue($date);
    }

    public function setValue($value)
    {
        if(is_string($value))
        {
            $value = explode(",", $value);
        }

        $dates = $value;

        if(is_array($dates) && count($dates) == 2)
        {
            $dateFrom = date_create($dates[0]);
            $dateTo = date_create($dates[1]);

            if($dateFrom instanceof DateTime && $dateTo instanceof DateTime)
            {
                $this->dateFrom = $dateFrom;
                $this->dateTo = $dateTo;
            }
        }
    }

    public function apply($model, RepositoryInterface $repository)
    {
        if($this->dateTo instanceof DateTime && $this->dateFrom instanceof DateTime)
        {
            $model = $model->whereBetween('updated_at', [$this->dateFrom->format('Y-m-d'), $this->dateTo->format('Y-m-d')]);
        }

        return $model;
    }
}