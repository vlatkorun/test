<?php

namespace App\Services\Auth;

use Illuminate\Contracts\Auth\Guard;
use Tymon\JWTAuth\JWTAuth;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class JwtGuard implements Guard
{
    /**
     * JWTAuth instance.
     *
     * @var \Tymon\JWTAuth\JWTAuth
     */
    protected $jwt;

    /**
     * The request instance.
     *
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * The currently authenticated user.
     *
     * @var \Illuminate\Contracts\Auth\Authenticatable
     */
    protected $user;

    public function __construct(JWTAuth $JWTAuth, Request $request)
    {
        $this->jwt = $JWTAuth;
        $this->request = $request;
    }

    public function check()
    {
        return ! is_null($this->user());
    }

    public function guest()
    {
        return ! $this->check();
    }

    public function user()
    {
        if(!is_null($this->user))
        {
            return $this->user;
        }

        $user = null;

        try {
            $user = $this->jwt->parseToken()->authenticate();
        } catch(JWTException $exception) {

        }

        return $this->user = $user;
    }

    public function id()
    {
        return $this->user() ? $this->user()->getAuthIdentifier() : null;
    }

    /**
     * Validate a user's credentials.
     *
     * @param  array  $credentials
     * @return bool
     */
    public function validate(array $credentials = [])
    {
        return $this->attempt($credentials) !== false;
    }

    /**
     * Set the current user.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @return $this
     */
    public function setUser(AuthenticatableContract $user)
    {
        $this->user = $user;

        return $this;
    }

    public function logout()
    {
        try {
            $this->jwt->invalidate();
        } catch(JWTException $exception) {

        }
    }

    public function getToken()
    {
        return (string) $this->jwt->getToken();
    }

    /**
     * Attempt to authenticate the user and return the token.
     *
     * @param array $credentials
     *
     * @return false|string
     */
    public function attempt(array $credentials = [])
    {
        return $this->jwt->attempt($credentials);
    }
}