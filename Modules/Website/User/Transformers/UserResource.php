<?php

namespace Modules\Website\User\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        $method = request()->route()->getActionMethod();
        $result = [
            'id'            => $this->id,
            'name'          => $this->name,
            'babies'        => BabyResource::collection($this->babies),
        ];
        if ($method == 'login') $result['access_token'] = $this->access_token;
        return $result;
    }
}
