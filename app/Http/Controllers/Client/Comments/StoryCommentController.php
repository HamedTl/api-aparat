<?php

namespace App\Http\Controllers\Client\Comments;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comments\CommentStoreRequest;
use App\Http\Requests\Comments\CommentUpdateRequest;
use App\Models\Interactions\Channel;
use App\Models\Interactions\Comment;
use App\Models\Interactions\Story;
use App\Services\Interactions\CommentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StoryCommentController extends Controller
{
    public function __construct(
        protected CommentService $commentService
    )
    {}

    public function store(CommentStoreRequest $request, Channel $channel, Story $story): JsonResponse
    {
        try {
            $request->validated();
            $comment = $this->commentService->create($request, $channel, $story);
            return $this->sendSuccess('comment created successfully', [
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

    public function update(CommentUpdateRequest $request, Comment $comment): JsonResponse
    {
        try {
            $request->validated();
            $comment = $this->commentService->update($request, $comment);
            return $this->sendSuccess('comment updated successfully', [
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

    public function destroy(Comment $comment): JsonResponse
    {
        try {
            $comment = $this->commentService->delete($comment);
            return $this->sendSuccess('comment deleted successfully', [
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
