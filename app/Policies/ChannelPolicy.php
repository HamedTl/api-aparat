<?php

namespace App\Policies;

use App\Models\Interactions\Channel;
use App\Models\User;

class ChannelPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function update(User $user, Channel $channel): bool
    {
        return $user->username === $channel->owner_user;
    }

    public function delete(User $user, Channel $channel): bool
    {
        return $user->username === $channel->owner_user;
    }
}
