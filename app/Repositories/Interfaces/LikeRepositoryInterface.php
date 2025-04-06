<?php

namespace App\Repositories\Interfaces;

use App\Repositories\Contracts\ContentInteractionRepositoryInterface;

interface LikeRepositoryInterface
{
    public function toggleLike($model, $type);
}
