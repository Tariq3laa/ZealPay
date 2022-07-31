<?php

namespace Modules\Website\User\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class BabyResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'        => $this->id,
            'name'      => $this->name,
        ];
    }
}
