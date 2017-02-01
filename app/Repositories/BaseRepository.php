<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository as Repository;
use App\Repositories\Criteria\NeedsSearchValueInterface;
use ReflectionClass;
use InvalidArgumentException;
use Illuminate\Events\Dispatcher;

abstract class BaseRepository extends Repository
{
    protected $searchFields = [];
    protected $orderFields = [];

    protected $eventDispatcher;

    public function setSearch($params)
    {
        foreach($params as $key => $value)
        {
            if(array_key_exists($key, $this->searchFields))
            {
                $criteriaClass = $this->searchFields[$key];

                if(in_array(NeedsSearchValueInterface::class, class_implements($criteriaClass)))
                {
                    $reflection = new ReflectionClass($criteriaClass);

                    $arguments = [];

                    foreach($reflection->getConstructor()->getParameters() as $param)
                    {
                        if(is_null($param->getClass()))
                        {
                            $arguments[$param->getName()] = $value;
                        }

                        if(!is_null($param->getClass()) && $param->getClass() instanceof ReflectionClass)
                        {
                            $depInstance = $this->app->make($param->getClass()->name);

                            if(!is_object($depInstance))
                            {
                                throw new InvalidArgumentException('Failed to instantiate dependency class: ');
                            }

                            $arguments[$param->getName()] = $depInstance;
                        }
                    }

                    $this->pushCriteria($reflection->newInstanceArgs($arguments));
                }

                if(!in_array(NeedsSearchValueInterface::class, class_implements($criteriaClass)))
                {
                    $this->pushCriteria(new $criteriaClass);
                }
            }
        }

        return $this;
    }

    public function setOrdering(array $ordering)
    {
        foreach($ordering as $key => $direction)
        {
            if(!empty($this->orderFields[$key][$direction]) && class_exists($this->orderFields[$key][$direction]))
            {
                $orderingClass = $this->orderFields[$key][$direction];
                $orderingInstance = new $orderingClass;
                $this->model = $orderingInstance->apply($this->model, $this);
            }
        }
        return $this;
    }

    public function boot()
    {
        $this->eventDispatcher = app(Dispatcher::class);
    }

    public function get(array $params = [])
    {
        if(!empty($params['search']) && is_array($params['search']))
        {
            $this->setSearch($params['search']);
        }

        if(!empty($params['ordering']) && is_array($params['ordering']))
        {
            $this->setOrdering($params['ordering']);
        }

        if(!empty($params['page']) && !empty($params['limit']) && is_integer($params['limit']))
        {
            return $this->paginate($params['limit']);
        }

        return $this->all();
    }
}