<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Users\AdminResource;
use App\Services\User\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AdminController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
        Gate::authorize('is-admin');
    }

    public function admins(): JsonResponse
    {
        return $this->sendSuccess('the admins list', [
            AdminResource::collection($this->userService->admins()),
        ]);
    }

    public function getAdminAbility(string $slug): JsonResponse
    {
        try {
            $this->userService->getAdminAbility($slug);
            return $this->sendSuccess("the $slug has been successfully admin", []);
        } catch (\Exception $e) {
            return $this->sendError("have an error in this stage.", [
                $e->getMessage(),
            ]);
        }
    }

    public function takeAdminAbility(string $slug): JsonResponse
    {
        try {
            $this->userService->takeAdminAbility($slug);
            return $this->sendSuccess("The $slug has been successfully take administrative", []);
        } catch (\Exception $e) {
            return $this->sendError("have an error in this stage.", [
                $e->getMessage(),
            ]);
        }
    }
}
