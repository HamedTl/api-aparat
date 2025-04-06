<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

abstract class Controller
{
    protected function sendSuccess(string $message = "", array $data, int $code = 200): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message'=> $message,
            'data'=> $data,
        ], $code);
    }

    protected function sendError(string $message = "", array $data, int $code = 400): JsonResponse
    {
        return response()->json([
            "status"=> "error",
            "message"=> $message,
            "data"=> $data,
        ], $code);
    }
}
