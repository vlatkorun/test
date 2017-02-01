<?php

namespace App\Http\Middleware;

use Closure;
use App\Http\Middleware\Handlers\Factory;
use Illuminate\Http\Request;
use Illuminate\Foundation\Application;

abstract class AbstractMiddleware
{
    protected $handler;
    protected $app;

    public function __construct(Factory $handlerFactory, Request $request, Application $app) {
        $this->handler = $handlerFactory->make($request);
        $this->app = $app;
    }

    public function handle($request, Closure $next)
    {}

    public function success($content, $headers = [])
    {
        return $this->handler->success($content, $headers);
    }

    public function error($content, $headers = [])
    {
        return $this->handler->error($content, $headers);
    }

    public function forbidden($content, $headers = [])
    {
        return $this->handler->forbidden($content, $headers);
    }

    public function unauthorized($content, $headers = [])
    {
        return $this->handler->unauthorized($content, $headers);
    }

    public function notFound($content, $headers = [])
    {
        return $this->handler->notFound($content, $headers);
    }

    public function validationErrors($content, $headers = [])
    {
        return $this->handler->validationErrors($content, $headers);
    }
}