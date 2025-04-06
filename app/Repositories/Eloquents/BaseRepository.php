<?php

namespace App\Repositories\Eloquents;

use App\Repositories\Contracts\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements BaseRepositoryInterface
{

    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all(): Collection
    {
        return $this->model->newQuery()->get();
    }

    public function find(string $slug)
    {
        return $this->model->newQuery()->where('slug', $slug)->first();
    }

    public function store(array $data)
    {
        return $this->model->newQuery()->create($data);
    }

    public function update(string $slug, array $data)
    {
        return $this->model->newQuery()->where('slug', $slug)->update($data);
    }

    public function delete(string $slug)
    {
        return $this->model->newQuery()->where('slug', $slug)->delete();
    }
}
