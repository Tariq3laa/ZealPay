<?php

namespace Modules\Website\User\Repositories;

use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\DB;
use Modules\Website\User\Entities\Baby;
use Modules\Common\Helpers\Traits\ApiPaginator;
use Modules\Website\User\Transformers\BabyResource;

class BabyRepository implements BabyRepositoryInterface
{
    use ApiPaginator;

    public function index()
    {
        $data = app(Pipeline::class)
            ->send(Baby::query())
            ->through([
                \Modules\Common\Filters\PaginationPipeline::class,
            ])
            ->thenReturn();
        $collection = BabyResource::collection($data);
        return $this->getPaginatedResponse($data, $collection);
    }

    public function store($request)
    {
        DB::beginTransaction();
        $model = Baby::query()->create($request->validated());
        DB::commit();
        return ['id' => $model->id];
    }

    public function show($request)
    {
        return new BabyResource(Baby::query()->find($request->baby));
    }

    public function update($request)
    {
        DB::beginTransaction();
        Baby::query()->where('id', $request->baby)->update($request->only(['name']));
        DB::commit();
        return 'Baby updated successfully .';
    }

    public function destroy($request)
    {
        $model = Baby::query()->find($request->baby);
        if(auth('client')->id() != $model->user_id) throw new \Exception('Only the parent of the child can delete the child.');
        $model->delete();
        return 'Baby Deleted Successfully .';
    }
}