<?php

namespace Modules\Website\User\Repositories;

interface AuthRepositoryInterface 
{
    public function login($request);
    public function register($request);
}