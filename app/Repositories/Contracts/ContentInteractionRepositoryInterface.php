<?php

namespace App\Repositories\Contracts;

use App\Models\Interactions\Channel;
use App\Models\Interactions\Comment;
use Illuminate\Database\Eloquent\Model;

interface ContentInteractionRepositoryInterface
{
    public function model(Model $model): Model;
    public function index(Channel $channel, Model $model);
    public function store(array $data, Channel $channel, Model $model);
    public function update(array $data, Model $model);
    public function destroy(Model $model);
}
