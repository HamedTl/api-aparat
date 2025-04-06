<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Resources\Interactions\SubscribtionResource;
use App\Models\Interactions\Channel;
use App\Services\Interactions\SubscriptionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function __construct(
        protected SubscriptionService $subscriptionService
    ){}

    public function subscribe(Channel $channel): JsonResponse
    {
        try {
            $subscribe = $this->subscriptionService->subscribe(request()->user()->username, $channel);
            return $this->sendSuccess('subscribe successfully', [$subscribe]);
        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), [
                'code' => $exception->getCode(),
                'line' => $exception->getLine(),
                'file' => $exception->getFile(),
            ]);
        }
    }

    public function unsubscribe(Channel $channel): JsonResponse
    {
        try {
            $subscribe = $this->subscriptionService->unsubscribe(request()->user()->username, $channel);
            return $this->sendSuccess('unsubscribe successfully', [$subscribe]);
        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), [
                'code' => $exception->getCode(),
                'line' => $exception->getLine(),
                'file' => $exception->getFile(),
            ]);
        }
    }

    public function getSubscription(): JsonResponse
    {
        return $this->sendSuccess('subscription list', [
            SubscribtionResource::make($this->subscriptionService->getSubscription(request()->user()->username)),
        ]);
    }
}
