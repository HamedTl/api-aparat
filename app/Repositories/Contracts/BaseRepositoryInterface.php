<?php

namespace App\Repositories\Contracts;


interface BaseRepositoryInterface
{
    public function all();
    public function find(string $slug);
    public function store(array $data);
    public function update(string $slug, array $data);
    public function delete(string $slug);
}
