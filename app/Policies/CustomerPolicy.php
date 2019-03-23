<?php

namespace App\Policies;

use App\Customer;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CustomerPolicy
{
    use HandlesAuthorization;

    public function __construct(User $user, Customer $customer)
    {
        return $user->hasRole('Admin');
    }

    public function viewAny(User $user)
    {
        return $user->hasRole('Admin');
    }

    public function create(User $user)
    {
        return $user->hasRole('Admin');
    }

    public function update(User $user)
    {
        return $user->hasRole('Admin');
    }

    public function view(User $user)
    {
        return $user->hasRole('Admin');
    }

    public function delete(User $user)
    {
        return $user->hasRole('Admin');
    }
}
