<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserLoginRequest;
use App\Http\Requests\User\UserStoreRequest;
use App\Services\User\UserService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function register(UserStoreRequest $request): JsonResponse
    {
        try {
            $request->validated();
            $user = $this->userService->create($request);
            return $this->sendSuccess("your have successfully registered.", [
                "user"=> $user,
            ], 201);
        } catch (\Exception $exception) {
            return $this->sendError("registration failed", [
                'description' => $exception->getMessage(),
            ]);
        }
    }

    public function login(UserLoginRequest $request): JsonResponse
    {
        try {
            $request->validated();

            if (!Auth::attempt(request(['username', 'password']))) {
                return $this->sendError('unauthorized', [], 401);
            }

            $user = $request->user();
            $token = $user->createToken("Access Token")->plainTextToken;

            return $this->sendSuccess("you have successfully logged in", [
                'token' => $token,
            ]);

        } catch (\Exception $exception) {
            return $this->sendError("login processing failed", [
                $exception->getMessage(),
            ]);
        }
    }

    public function logout(Request $request): JsonResponse
    {
        try {
            $request->user()->tokens()->delete();
            return $this->sendSuccess("you have successfully loged out", []);
        } catch (\Exception $exception) {
            return $this->sendError("logout processing failed", [
                $exception->getMessage(),
            ]);
        }
    }
}
