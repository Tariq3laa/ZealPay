<?php

namespace Modules\Website\User\Repositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Modules\Website\User\Entities\User;
use Modules\Website\User\Transformers\UserResource;
use Modules\Website\User\Repositories\AuthRepositoryInterface;

class AuthRepository implements AuthRepositoryInterface
{
    public function login($request)
    {
        $item = User::query()->where('name', $request->name)->first();
        if (!$item || !$item['access_token'] = Auth::guard('client')->login($item)) throw new \Exception('The name you entered is invalid.', 401);
        return new UserResource($item);
    }

    public function register($request)
    {
        DB::beginTransaction();
        User::query()->create($request->validated());
        DB::commit();
        return 'Account created successfully';
    }
}