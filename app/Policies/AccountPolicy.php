<?php

namespace App\Policies;

use App\Account;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AccountPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->salesRep();
    }

    public function create(User $user)
    {
        return $user->salesRep();
    }

    public function update(User $user, Account $account)
    {
        return $user->salesRep() && $account->sales_rep_id == $user->id;
    }

    public function view(User $user, Account $account)
    {
        return $user->salesRep() && $account->sales_rep_id == $user->id;
    }

    public function delete(User $user, Account $account)
    {
        return $user->salesRep() && $account->sales_rep_id == $user->id;
    }
}
