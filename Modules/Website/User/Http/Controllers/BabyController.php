<?php

namespace Modules\Website\User\Http\Controllers;

use Modules\Website\User\Services\BabyService;
use Modules\Website\User\Http\Requests\Baby\BabyRequest;

class BabyController
{
    private $service;

    public function __construct(BabyService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return $this->service->index();
    }

    public function store(BabyRequest $request)
    {
        return $this->service->store($request);
    }

    public function show(BabyRequest $request)
    {
        return $this->service->show($request);
    }

    public function update(BabyRequest $request)
    {
        return $this->service->update($request);
    }

    public function destroy(BabyRequest $request)
    {
        return $this->service->destroy($request);
    }
}
