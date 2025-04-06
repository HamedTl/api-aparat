<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserUpdateRequest;
use App\Http\Resources\Users\UserResource;
use App\Services\User\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /*
     * User Profile
     * -----------------------------------
     * This method show user profile information.
    */
    public function index(string $slug): JsonResponse
    {
        return $this->sendSuccess('user profile', [
            UserResource::make($this->userService->show($slug)),
        ]);
    }

    public function update(string $slug, UserUpdateRequest $request): JsonResponse
    {
        try {
            $request->validated();
            $user = $this->userService->update($request, $slug);
            return $this->sendSuccess('user information successfully updated', [
                $user,
            ]);
        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), [
                'code' => $exception->getCode(),
                'line' => $exception->getLine(),
                'file' => $exception->getFile(),
            ]);
        }
    }
}
