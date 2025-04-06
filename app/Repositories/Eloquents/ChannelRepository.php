<?php

namespace App\Repositories\Eloquents;

use App\Models\Interactions\Channel;
use App\Repositories\Interfaces\ChannelRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class ChannelRepository implements ChannelRepositoryInterface
{

    public function model(): Channel
    {
        return new Channel();
    }

    public function all(): \Illuminate\Database\Eloquent\Collection
    {
        return Channel::all();
    }

    public function find(Model $model): Model
    {
        return $model;
    }

    public function store(array $data)
    {
        return Channel::create($data);
    }

    public function update(Model $model, array $data): bool
    {
        return $model->update($data);
    }

    public function delete(Model $model): ?bool
    {
        return $model->delete();
    }

    public function owner(Model $model): Model
    {
        return $model->load('user');
    }

    public function videos(Model $model): Model
    {
        return $model->load('videos');
    }

    public function stories(Model $model): Model
    {
        return $model->load('stories');
    }

    public function medias(Model $model): Model
    {
        return $model->load('videos', 'stories');
    }
}
