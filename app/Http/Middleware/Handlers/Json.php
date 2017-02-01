<?php

namespace App\Http\Middleware\Handlers;

use App\Http\StatusCodes;

class Json extends AbstractHandler
{
    public function success($content, $headers = [])
    {
        return $this->setStatusCode(StatusCodes::OK)
            ->respond($this->prepareContent($content), $headers);
    }

    public function error($content, $headers = [])
    {
        return $this->setStatusCode(StatusCodes::WRONG_ARGS)
            ->respond($this->prepareContent($content), $headers);
    }

    public function forbidden($content, $headers = [])
    {
        return $this->setStatusCode(StatusCodes::FORBIDDEN)
            ->respond($this->prepareContent($content), $headers);
    }

    public function unauthorized($content, $headers = [])
    {
        return $this->setStatusCode(StatusCodes::UNAUTHORIZED)
            ->respond($this->prepareContent($content), $headers);
    }

    public function notFound($content, $headers = [])
    {
        return $this->setStatusCode(StatusCodes::NOT_FOUND)
            ->respond($this->prepareContent($content), $headers);
    }

    public function validationErrors($content, $headers = [])
    {
        return $this->setStatusCode(StatusCodes::VALIDATION_ERRORS)
            ->respond($this->prepareContent($content), $headers);
    }

    protected function prepareContent($content)
    {
        if(!is_array($content))
        {
            return ['message' => $content];
        }

        return $content;
    }
}