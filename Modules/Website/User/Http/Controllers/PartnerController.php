<?php

namespace Modules\Website\User\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Website\User\Services\PartnerService;

class PartnerController
{
    private $service;

    public function __construct(PartnerService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return $this->service->index();
    }

    public function store(Request $request)
    {
        return $this->service->store($request);
    }
}
