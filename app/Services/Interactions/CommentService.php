<?php

namespace App\Services\Interactions;

use App\Models\Interactions\Channel;
use App\Models\Interactions\Comment;
use App\Repositories\Interfaces\CommentsRepositoryInterface;
use App\Services\HelperServices\CacheService;
use Illuminate\Database\Eloquent\Model;

class CommentService
{
    public function __construct(
        protected CommentsRepositoryInterface $commentRepository,
        protected CacheService $cacheService
    ){}

    public function comments(Channel $channel, Model $model)
    {
        return $this->commentRepository->index($channel, $model);
    }

    public function create(object $data, Channel $channel, Model $model)
    {
        $this->cacheService->handleCache($this->commentRepository->model($model));
        return $this->commentRepository->store([
            'username' => request()->user()->username,
            'comment' => $data->comment,
        ], $channel, $model);
    }

    public function update(object $data, Comment $comment): bool
    {
        $this->cacheService->handleCache($this->commentRepository->model($comment));
        return $this->commentRepository->update([
            'comment' => $data->comment,
        ], $comment);
    }

    public function delete(Comment $comment): ?bool
    {
        $this->cacheService->handleCache($this->commentRepository->model($comment));
        return $this->commentRepository->destroy($comment);
    }
}
