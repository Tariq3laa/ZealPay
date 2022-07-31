<?php

namespace Modules\Website\User\Http\Controllers;

use Modules\Website\User\Services\AuthService;
use Modules\Website\User\Http\Requests\Auth\LoginRequest;
use Modules\Website\User\Http\Requests\Auth\RegisterRequest;

class AuthController
{
    private $service;

    public function __construct(AuthService $service)
    {
        $this->service = $service;
    }

    public function login(LoginRequest $request)
    {
        return $this->service->login($request);
    }

    public function register(RegisterRequest $request)
    {
        return $this->service->register($request);
    }
}
