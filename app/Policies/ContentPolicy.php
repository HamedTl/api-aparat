<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class ContentPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function update(User $user, Model $model)
    {
        return $user->username === $model->channels->owner_user;
    }

    public function delete(User $user, Model $model)
    {
        return $user->username === $model->channels->owner_user;
    }
}
