<?php

namespace Modules\Website\User\Services;

use Illuminate\Support\Facades\DB;
use Modules\Common\Http\Controllers\InitController;
use Modules\Website\User\Repositories\PartnerRepository;

class PartnerService extends InitController
{
    private $repository;

    public function __construct(PartnerRepository $repository)
    {
        parent::__construct();
        $this->repository = $repository;
    }

    public function index()
    {
        try {
            return $this->respondWithSuccess($this->repository->index());
        } catch (\Exception $e) {
            return $this->respondError($e->getMessage());
        }
    }

    public function store($request)
    {
        try {
            return $this->respondCreated($this->repository->store($request));
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->respondError($e->getMessage());
        }
    }
}