<?php

namespace Modules\Website\User\Repositories;

interface PartnerRepositoryInterface 
{
    public function index();
    public function store($request);
}