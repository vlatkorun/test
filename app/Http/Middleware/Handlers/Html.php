<?php

namespace app\Http\Middleware\Handlers;

use App\Http\StatusCodes;

class Html extends AbstractHandler
{
    public function success($content, $headers = [])
    {
        return redirect('/');
    }

    public function error($content, $headers = [])
    {
        return $this->setStatusCode(StatusCodes::WRONG_ARGS)
            ->respond(view('errors.400', $this->prepareContent($content)), $headers);
    }

    public function forbidden($content, $headers = [])
    {
        return $this->setStatusCode(StatusCodes::FORBIDDEN)
            ->respond(view('errors.403', $this->prepareContent($content)), $headers);
    }

    public function unauthorized($content, $headers = [])
    {
        return $this->setStatusCode(StatusCodes::UNAUTHORIZED)
            ->respond(view('errors.401', $this->prepareContent($content)), $headers);
    }

    public function notFound($content, $headers = [])
    {
        return $this->setStatusCode(StatusCodes::NOT_FOUND)
            ->respond(view('errors.404', $this->prepareContent($content)), $headers);
    }

    public function validationErrors($content, $headers = [])
    {
        return $this->setStatusCode(StatusCodes::VALIDATION_ERRORS)
            ->respond(view('errors.422', $this->prepareContent($content)), $headers);
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