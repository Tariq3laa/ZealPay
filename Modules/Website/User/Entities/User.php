<?php

namespace Modules\Website\User\Entities;

use Modules\Website\User\Entities\Baby;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    protected $guarded = ['id'];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * Get all of the Articles for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function babies()
    {
        return $this->hasMany(Baby::class);
    }

    /**
     * Get all of the Partners for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function partners()
    {
        return $this->belongsToMany(User::class, 'user_partners', 'user_id', 'partner_id');
    }
}
