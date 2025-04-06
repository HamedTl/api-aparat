<?php

namespace App\Services\Interactions;

use App\Repositories\Interfaces\LikeRepositoryInterface;

class LikeService
{
    public function __construct(
        protected LikeRepositoryInterface $likeRepository
    )
    {
    }

    public function toggleLikes($model, $type)
    {
        return $this->likeRepository->toggleLike($model, $type);
    }
}
