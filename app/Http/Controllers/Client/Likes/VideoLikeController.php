<?php

namespace App\Http\Controllers\Client\Likes;

use App\Http\Controllers\Controller;
use App\Models\Interactions\Channel;
use App\Models\Interactions\Video;
use App\Services\Interactions\LikeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VideoLikeController extends Controller
{
    public function __construct(
        protected LikeService $likeService
    )
    {
    }

    public function like(Channel $channel, Video $video): JsonResponse
    {
        try {
            $like = $this->likeService->toggleLikes($video, 'like');
            return $this->sendSuccess('like successfully', ['like' => $like]);
        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), [
                'code' => $exception->getCode(),
                'line' => $exception->getLine(),
                'file' => $exception->getFile(),
            ]);
        }
    }

    public function dislike(Channel $channel, Video $video): JsonResponse
    {
        try {
            $dislike = $this->likeService->toggleLikes($video, 'dislike');
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
