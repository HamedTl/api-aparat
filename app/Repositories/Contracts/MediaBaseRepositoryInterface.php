<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Model;

interface MediaBaseRepositoryInterface
{
    public function model();
    public function all();
    public function find(Model $model);

    public function owner(Model $model);

    public function videos(Model $model);
    public function stories(Model $model);

    public function medias(Model $model);
    public function store(array $data);
    public function update(Model $model, array $data);
    public function delete(Model $model);
}
