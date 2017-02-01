<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller as BaseController;
use App\Http\StatusCodes;
use Prettus\Repository\Contracts\PresenterInterface;

class Controller extends BaseController
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

    protected function respondWithItem($item, PresenterInterface $presenter, $message = '', array $headers = [])
    {
        return $this->respondWithArray(array_merge(['message' => $message], $presenter->present($item)), $headers);
    }

    protected function respondWithCollection($collection, PresenterInterface $presenter, $message = '', array $headers = [])
    {
        return $this->respondWithArray(array_merge(['message' => $message], $presenter->present($collection)), $headers);
    }

    protected function respondWithArray(array $array, array $headers = [])
    {
        $headers[] = ['header_name' => 'Content-Type', 'header_value' => 'application/json'];

        $response = response($array, $this->statusCode);

        foreach($headers as $header)
        {
            $response->header($header['header_name'], $header['header_value']);
        }

        return $response;
    }

    protected function respondWithError($message, $additionalMessages = ['key' => '', 'messages' => []], array $headers = [])
    {
        $error = [
            'error' => [
                'http_code' => $this->statusCode,
                'message' => $message,
            ]
        ];

        //Check to see if we have supplied additional messages in the response like: validation, some info text, etc...
        if( ! empty($additionalMessages['key']) &&  ! empty($additionalMessages['messages']))
        {
            $error['error'][$additionalMessages['key']] = $additionalMessages['messages'];
        }

        return $this->respondWithArray($error);
    }

    /**
     * Generates a Response with a 403 HTTP header and a given message.
     *
     * @return \Illuminate\Http\Response
     */
    public function errorForbidden($message = '', array $headers = [])
    {
        return $this->setStatusCode(StatusCodes::FORBIDDEN)->respondWithError($message, $headers);
    }

    /**
     * Generates a Response with a 500 HTTP header and a given message.
     *
     * @return \Illuminate\Http\Response
     */
    public function errorInternalError($message = '', array $headers = [])
    {
        return $this->setStatusCode(StatusCodes::INTERNAL_ERROR)->respondWithError($message, $headers);
    }

    /**
     * Generates a Response with a 404 HTTP header and a given message.
     *
     * @return \Illuminate\Http\Response
     */
    public function errorNotFound($message = '', array $headers = [])
    {
        return $this->setStatusCode(StatusCodes::NOT_FOUND)->respondWithError($message,  $headers);
    }

    /**
     * Generates a Response with a 401 HTTP header and a given message.
     *
     * @return \Illuminate\Http\Response
     */
    public function errorUnauthorized($message = '', array $headers = [])
    {
        return $this->setStatusCode(StatusCodes::UNAUTHORIZED)->respondWithError($message, $headers);
    }

    /**
     * Generates a Response with a 400 HTTP header and a given message.
     *
     * @return \Illuminate\Http\Response
     */
    public function errorWrongArgs($message = '', array $headers = [])
    {
        return $this->setStatusCode(StatusCodes::WRONG_ARGS)->respondWithError($message, $headers);
    }

    /**
     * Generates a Response with a 400 HTTP header and a given message plus the validation errors.
     *
     * @return \Illuminate\Http\Response
     */
    public function errorValidationErrors($message, array $validationMessages, array $headers = [])
    {
        $errors = ['key' => 'validation', 'messages' => []];

        foreach($validationMessages as $key => $messages)
        {
            $errors['messages'][][$key] = $messages;
        }

        return $this->setStatusCode(StatusCodes::VALIDATION_ERRORS)->respondWithError($message, $errors, $headers);
    }

    /**
     * Generates a Response with a 200 HTTP header and a given message
     *
     * @return \Illuminate\Http\Response
     */
    public function success($message, array $additionalMessages = [], array $headers = [])
    {
        $params = array_merge(['message' => $message], $additionalMessages);

        return $this->setStatusCode(StatusCodes::OK)->respondWithArray($params, $headers);
    }

    /**
     * Generates a Response with a 400 HTTP header and a given message.
     *
     * @return \Illuminate\Http\Response
     */
    public function error($message, array $additionalMessages = [],array $headers = [])
    {
        return $this->setStatusCode(StatusCodes::WRONG_ARGS)->respondWithError($message, $additionalMessages, $headers);
    }
}