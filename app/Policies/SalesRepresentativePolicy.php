<?php

namespace App\Policies;

use App\NovaModels\SalesRepresentative;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SalesRepresentativePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->hasRole('Admin');
    }

    public function update(User $user, SalesRepresentative $salesRep)
    {
        return $user->hasRole('Admin');
    }

    public function delete(User $user, SalesRepresentative $salesRep)
    {
        return $user->hasRole('Admin');
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
