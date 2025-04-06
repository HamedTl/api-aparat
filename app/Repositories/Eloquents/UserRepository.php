<?php

namespace App\Repositories\Eloquents;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{

    public function model(): User
    {
        return new User();
    }

    public function all(): \Illuminate\Database\Eloquent\Collection
    {
        return User::all();
    }

    public function admins()
    {
        return User::isAdmins()->get();
    }

    public function find(string $slug): User
    {
        return User::where("slug", $slug)->first();
    }

    public function channels(string $slug)
    {
        $user = User::with('channels')->where("slug", $slug)->first();
        return $user->channels;
    }

    public function store(array $data)
    {
        return User::create($data);
    }

    public function update(string $slug, array $data): User
    {
        return User::where("slug", $slug)->first()->update($data);
    }

    public function delete(string $slug): User
    {
        return User::where("slug", $slug)->delete();
    }
}
