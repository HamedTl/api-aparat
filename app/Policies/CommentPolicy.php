<?php

namespace App\Policies;

use App\Models\Interactions\Comment;
use App\Models\User;

class CommentPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function update(User $user, Comment $comment): bool
    {
        return $user->username === $comment->username;
    }

    public function delete(User $user, Comment $comment): bool
    {
        return $user->username === $comment->username;
    }
}
