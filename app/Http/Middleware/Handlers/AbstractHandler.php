<?php

namespace App\Http\Middleware\Handlers;

use App\Http\StatusCodes;

abstract class AbstractHandler
{

    protected $statusCode = StatusCodes::OK;

    /**
     * Getter for statusCode
     *
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * Setter for statusCode
     *
     * @param int $statusCode Value to set
     *
     * @return self
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    protected function respond($content, array $headers = [])
    {
        $response = response($content, $this->statusCode);

        foreach($headers as $header)
        {
            $response->header($header['header_name'], $header['header_value']);
        }

        return $response;
    }

    public function success($content, $headers = [])
    {}
    public function error($content, $headers = [])
    {}
    public function forbidden($content, $headers = [])
    {}
    public function unauthorized($content, $headers = [])
    {}
    public function notFound($content, $headers = [])
    {}
    public function validationErrors($content, $headers = [])
    {}
}