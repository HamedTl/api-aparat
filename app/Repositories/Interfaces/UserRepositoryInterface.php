<?php

namespace App\Repositories\Interfaces;

use App\Models\User;

interface UserRepositoryInterface
{
    public function model(): User;
    public function all();
    public function admins();
    public function find(string $slug): User;

    public function channels(string $slug);
    public function store(array $data);
    public function update(string $slug, array $data): User;
    public function delete(string $slug): User;
}
