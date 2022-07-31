<?php

namespace Modules\Common\Entities;

use Illuminate\Database\Eloquent\Model;


class Media extends Model
{
    protected $table = 'media';
    protected $guarded = ['id'];

    protected $appends = ['full_path', 'file_type'];

    public function getFullPathAttribute()
    {
        return \URL::to('') . '/' . $this->path;
    }
    public function getFileTypeAttribute()
    {
        if (str_contains($this->type, 'video')) {
            return 'video';
        }
        if (str_contains($this->type, 'audio')) {
            return 'audio';
        }
        return 'image';
    }
}
