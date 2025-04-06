<?php

namespace App\Http\Controllers\Client\Comments;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comments\CommentStoreRequest;
use App\Http\Requests\Comments\CommentUpdateRequest;
use App\Models\Interactions\Channel;
use App\Models\Interactions\Comment;
use App\Models\Interactions\Video;
use App\Services\Interactions\CommentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class VideoCommentController extends Controller
{
    public function __construct(
        protected CommentService $commentService,
    )
    {}

    public function store(CommentStoreRequest $request, Channel $channel, Video $video): JsonResponse
    {
        try {
            $request->validated();
            $comment = $this->commentService->create($request, $channel, $video);
            return $this->sendSuccess('comments created successfully', [
                'comment' => $comment
            ], 201);
        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), [
                'code' => $exception->getCode(),
                'line' => $exception->getLine(),
                'file' => $exception->getFile(),
            ]);
        }
    }

    public function update(CommentUpdateRequest $request, Channel $channel, Video $video, Comment $comment): JsonResponse
    {
        try {
            Gate::authorize('comment-update', $comment);
            $request->validated();
            $comment = $this->commentService->update($request, $comment);
            return $this->sendSuccess('comments updated successfully', [
                'comment' => $comment
            ]);
        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), [
                'code' => $exception->getCode(),
                'line' => $exception->getLine(),
                'file' => $exception->getFile(),
            ]);
        }
    }

    public function destroy(Channel $channel, Video $video, Comment $comment): JsonResponse
    {
        try {
            Gate::authorize('comment-delete', $comment);
            $comment = $this->commentService->delete($comment);
            return $this->sendSuccess('comments deleted successfully', [
                'comment' => $comment
            ]);
        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), [
                'code' => $exception->getCode(),
                'line' => $exception->getLine(),
                'file' => $exception->getFile(),
            ]);
        }
    }
}
