<?php

namespace App\Scope;

use App\Role;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class SalesRepTypeScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        $builder->whereHas('roles')->join('user_roles', 'user_roles.user_id', '=', 'users.id')->where('user_roles.role_id', Role::getRole('Sales Representative')->id);
    }
}