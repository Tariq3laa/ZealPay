<?php

namespace Modules\Website\User\Http\Requests\Baby;

use Modules\Common\Http\Requests\ResponseShape;

class BabyRequest extends ResponseShape
{
    public function all($keys = null)
    {
        $data = parent::all($keys);
        $data['baby'] =  $this->route('baby');
        return $data;
    }

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        switch ($this->method()) {
            case 'PUT': 
            case 'POST': {
                    return [
                        'name'          => 'required|min:2',
                        'baby'          => 'nullable|exists:babies,id'
                    ];
                }
            case 'GET': 
            case 'DELETE': {
                    return [
                        'baby'          => 'required|exists:babies,id'
                    ];
                }
            default:
                break;
        }
    }
}
