<?php

namespace App\Policies;

use App\Product;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;

    public function __construct(User $user, Product $product)
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
