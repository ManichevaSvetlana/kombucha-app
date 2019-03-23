<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ForumCommentPolicy
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
        $isMain = $model->discussion->posts()->whereUserId($model->user_id)->first()->id == $model->id;
        return $user->hasRole('Admin') && !$isMain;
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
