<?php

namespace App\NovaModels;

use App\Customer;
use App\Role;
use App\Scope\UserScope;
use Illuminate\Database\Eloquent\Model;

class User extends \App\User
{

    /* Model's additional functions */

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new UserScope);
    }
    /* End of model's additional functions */

}
