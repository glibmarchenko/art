<?php

namespace App\Models\Users;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Artist extends User
{
    use Notifiable;

    protected $cascadeDeletes = ['comments'];

    protected static function boot()
    {
        parent::boot();
    }

    public function newQuery($excludeDeleted = true)
    {
        return parent::newQuery()->whereRole(2);
    }


}
