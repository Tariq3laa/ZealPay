<?php

namespace Modules\Website\User\Repositories;

use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\DB;
use Modules\Common\Helpers\Traits\ApiPaginator;
use Modules\Website\User\Transformers\UserResource;

class PartnerRepository implements PartnerRepositoryInterface
{
    use ApiPaginator;

    public function index()
    {
        $data = app(Pipeline::class)
            ->send(auth('client')->user()->partners())
            ->through([
                \Modules\Common\Filters\PaginationPipeline::class,
            ])
            ->thenReturn();
        $collection = UserResource::collection($data);
        return $this->getPaginatedResponse($data, $collection);
    }

    public function store($request)
    {
        DB::beginTransaction();
        auth('client')->user()->partners()->attach($request->partner_id);
        DB::commit();
        return ['Partner added successfully.'];
    }
}