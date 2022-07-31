<?php

namespace Modules\Website\User\Services;

use Illuminate\Support\Facades\DB;
use Modules\Common\Http\Controllers\InitController;
use Modules\Website\User\Repositories\AuthRepository;

class AuthService extends InitController
{
    private $repository;

    public function __construct(AuthRepository $repository)
    {
        parent::__construct();
        $this->repository = $repository;
    }

    public function login($request)
    {
        try {
            return $this->respondWithSuccess($this->repository->login($request));
        } catch (\Exception $e) {
            $code = getCode($e->getCode());
            $message = $e->getMessage();
            return jsonResponse($code, $message);
        }
    }

    public function register($request)
    {
        try {
            return $this->respondCreated([$this->repository->register($request)]);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->respondError($e->getMessage());
        }
    }
}