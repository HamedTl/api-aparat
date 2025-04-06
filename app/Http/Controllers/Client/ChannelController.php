<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Channels\ChannelStoreRequest;
use App\Http\Requests\Channels\ChannelUpdateRequest;
use App\Http\Resources\Interactions\ChannelResource;
use App\Models\Interactions\Channel;
use App\Services\Interactions\ChannelService;
use App\Services\Interactions\ViewService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;

class ChannelController extends Controller
{
    public function __construct(
        protected ChannelService $channelService
    )
    {
    }

    public function index(): JsonResponse
    {
        return $this->sendSuccess("channels list", [
            ChannelResource::collection($this->channelService->all())
        ]);
    }

    public function store(ChannelStoreRequest $request): JsonResponse
    {
        try {
            $request->validated();
            $channel = $this->channelService->create($request);
            return $this->sendSuccess("channel created successfully", [
                $channel
            ], 201);
        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), [
                'code' => $exception->getCode(),
                'line' => $exception->getLine(),
                'file' => $exception->getFile(),
            ]);
        }
    }

    public function show(Channel $channel): JsonResponse
    {
        return $this->sendSuccess("channel details", [
            ChannelResource::make($this->channelService->show($channel)),
        ]);
    }

    public function update(ChannelUpdateRequest $request, Channel $channel): JsonResponse
    {
        try {
            Gate::authorize('channel-update', $channel);
            $request->validated();
            $channelUpdate = $this->channelService->update($request, $channel);
            return $this->sendSuccess("channel updated successfully", [
                $channelUpdate,
            ], 200);
        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), [
                'code' => $exception->getCode(),
                'line' => $exception->getLine(),
                'file' => $exception->getFile(),
            ]);
        }
    }

    public function destroy(Channel $channel): JsonResponse
    {
        try {
            Gate::authorize('channel-delete', $channel);
            $channelDelete = $this->channelService->delete($channel);
            return $this->sendSuccess("channel deleted successfully", [
                $channelDelete,
            ], 200);
        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), [
                'code' => $exception->getCode(),
                'line' => $exception->getLine(),
                'file' => $exception->getFile(),
            ]);
        }
    }
}
