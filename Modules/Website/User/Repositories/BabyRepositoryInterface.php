<?php

namespace Modules\Website\User\Repositories;

interface BabyRepositoryInterface 
{
    public function index();
    public function store($request);
    public function show($request);
    public function update($request);
    public function destroy($request);
}