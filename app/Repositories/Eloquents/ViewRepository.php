<?php

namespace App\Repositories\Eloquents;

use App\Models\Interactions\Channel;
use App\Models\Interactions\Story;
use App\Models\Interactions\Video;
use App\Models\Interactions\View;
use App\Repositories\Interfaces\ViewRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class ViewRepository implements ViewRepositoryInterface
{

    public function model(Model $model): Model
    {
        return match (true) {
            $model instanceof Video => new Video(),
            $model instanceof Story => new Story(),
            default => new View()
        };
    }

    public function index(Channel $channel, Model $model)
    {
        return $model->views()->get();
    }

    public function store(array $data, Channel $channel, Model $model)
    {
        $view = $model->views()->firstOrNew([]);
        $view->views = $view->exists ? $view->views + 1 : 1;
        $view->save();

        return $view;
    }

    public function update(array $data, Model $model): bool
    {
        return $model->updateOrFail($data);
    }

    public function destroy(Model $model): ?bool
    {
        return $model->deleteOrFail();
    }
}
