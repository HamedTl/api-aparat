<?php

namespace App\Http\Controllers\Client\Likes;

use App\Http\Controllers\Controller;
use App\Models\Interactions\Story;
use App\Services\Interactions\LikeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StoryLikeController extends Controller
{
    public function __construct(
        protected LikeService $likeService
    )
    {
    }

    public function like(Story $story): JsonResponse
    {
        try {
            $like = $this->likeService->toggleLikes($story, 'like');
            return $this->sendSuccess('like successfully', ['like' => $like]);
        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), [
                'code' => $exception->getCode(),
                'line' => $exception->getLine(),
                'file' => $exception->getFile(),
            ]);
        }
    }

    public function dislike(Story $story): JsonResponse
    {
        try {
            $dislike = $this->likeService->toggleLikes($story, 'dislike');
            return $this->sendSuccess('like successfully', ['dislike' => $dislike]);
        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), [
                'code' => $exception->getCode(),
                'line' => $exception->getLine(),
                'file' => $exception->getFile(),
            ]);
        }
    }

}
