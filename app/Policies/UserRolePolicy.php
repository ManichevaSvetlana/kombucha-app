<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserRolePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->hasRole('Admin');
    }

    public function update(User $user)
    {
        return $user->hasRole('Admin');
    }

    public function delete(User $user, $model)
    {
        return $user->hasRole('Admin') && $model->id != $user->id;
    }

    public function create(User $user)
    {
        return $user->hasRole('Admin');
    }

    public function view(User $user)
    {
        return $user->hasRole('Admin');
    }
}
