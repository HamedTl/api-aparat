<?php

namespace App\Repositories\Eloquents;

use App\Models\Interactions\Channel;
use App\Models\Interactions\Comment;
use App\Models\Interactions\Story;
use App\Models\Interactions\Video;
use App\Repositories\Interfaces\CommentsRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CommentRepository implements CommentsRepositoryInterface
{
    public function model(Model $model): Model
    {
        return match (true) {
          $model instanceof Video => new Video(),
          $model instanceof Story => new Story(),
          default => new Comment()
        };
    }

    public function index(Channel $channel, Model $model)
    {
        return $model->comments()->get();
    }

    public function store(array $data, Channel $channel, Model $model)
    {
        return $model->comments()->create($data);
    }

    /**
     * @throws \Throwable
     */
    public function update(array $data, Model $model): bool
    {
        return $model->updateOrFail($data);
    }

    /**
     * @throws \Throwable
     */
    public function destroy(Model $model): ?bool
    {
        return $model->deleteOrFail();
    }
}
