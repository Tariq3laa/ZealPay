<?php

namespace Modules\Website\User\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Website\User\Entities\User;

class Baby extends Model
{
    protected $guarded = ['id'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->user_id = auth('client')->id();
        });
    }

    /**
     * Get the User that owns the Article
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(User::class);
    }
}
