<?php

namespace App\Services\User;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\HelperServices\CacheService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class UserService
{

    public function __construct(
        protected UserRepositoryInterface $userRepository,
        protected CacheService $cacheService
    )
    {
    }

    public function all()
    {
        return $this->userRepository->all();
    }

    public function admins()
    {
        return $this->userRepository->admins();
    }

    public function show(string $slug): User
    {
        return $this->userRepository->find($slug);
    }

    public function create(object $data)
    {

        if (!is_null($data->avatar)) {
            $avatar = time() . "_" . $data->avatar->getClientOriginalName();
            $data->avatar->move(public_path("images/users"), $avatar);
        }

        $this->cacheService->handleCache($this->userRepository->model());
        return $this->userRepository->store([
            'firstname' => $data->firstname,
            'lastname' => $data->lastname,
            'username' => $data->username,
            'email' => $data->email,
            'password' => Hash::make($data->password),
            'avatar' => (!is_null($data->avatar)) ? $avatar : null,
        ]);
    }


    public function update(object $data, string $slug): User
    {
        $user = $this->userRepository->find($slug);
        if (!is_null($data->avatar)) {
            File::delete(public_path('images/users/' . $user->avatar));

            $avatar = time() . "_" . $data->avatar->getClientOriginalName();
            $data->avatar->move(public_path("images/users"), $avatar);
        }

        $this->cacheService->handleCache($this->userRepository->model());
        return $this->userRepository->update($slug, [
            'firstname' => $data->firstname,
            'lastname' => $data->lasname,
            'username' => $data->username,
            'email' => $data->email,
            'password' => Hash::make($data->password),
            'avatar' => !is_null($data->avatar) ? $avatar : null,
        ]);
    }

    public function getAdminAbility(string $slug): User
    {
        $this->cacheService->handleCache($this->userRepository->model());
        return $this->userRepository->update($slug, [
            'is_admin' => true,
        ]);
    }

    public function takeAdminAbility(string $slug): User
    {
        $this->cacheService->handleCache($this->userRepository->model());
        return $this->userRepository->update($slug, [
            'is_admin' => false,
        ]);
    }

    public function delete(string $slug): User
    {
        $user = $this->userRepository->find($slug);
        File::delete(public_path('images/users/' . $user->avatar));
        $this->cacheService->handleCache($this->userRepository->model());
        return $this->userRepository->delete($slug);
    }
}
