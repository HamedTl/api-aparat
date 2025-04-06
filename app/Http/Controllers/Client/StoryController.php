<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Stories\StoryStoreRequest;
use App\Http\Requests\Stories\StoryUpdateRequest;
use App\Http\Resources\Interactions\StoryResource;
use App\Models\Interactions\Channel;
use App\Models\Interactions\Story;
use App\Services\Interactions\StoryService;
use App\Services\Interactions\ViewService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class StoryController extends Controller
{
    public function __construct(
        protected StoryService $storyService,
        protected ViewService $viewService,
    )
    {
    }

    public function index(): JsonResponse
    {
        return $this->sendSuccess('stories list', [
            StoryResource::collection($this->storyService->all()),
        ]);
    }

    public function store(StoryStoreRequest $request, Channel $channel): JsonResponse
    {
        try {
            $request->validated();
            $story = $this->storyService->create($request, $channel->channel_name);
            return $this->sendSuccess('story created successfully', [
                $story,
            ], 201);
        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), [
                'code' => $exception->getCode(),
                'line' => $exception->getLine(),
                'file' => $exception->getFile(),
            ]);
        }
    }

    public function show(Channel $channel, Story $story): JsonResponse
    {
        $this->viewService->create($channel, $story);
        return $this->sendSuccess('story details', [
            StoryResource::make($this->storyService->show($channel, $story)),
        ]);
    }

    public function update(StoryUpdateRequest $request, Channel $channel, Story $story): JsonResponse
    {
        try {
            Gate::authorize('content-update', $story);
            $request->validated();
            $story = $this->storyService->update($channel, $story, $request);
            return $this->sendSuccess('story updated successfully', [
                $story,
            ], 201);
        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), [
                'code' => $exception->getCode(),
                'line' => $exception->getLine(),
                'file' => $exception->getFile(),
            ]);
        }
    }

    public function destroy(Channel $channel, Story $story): JsonResponse
    {
        try {
            Gate::authorize('content-delete', $story);
            $story = $this->storyService->delete($channel, $story);
            return $this->sendSuccess('story deleted successfully', [
                $story,
            ], 201);
        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), [
                'code' => $exception->getCode(),
                'line' => $exception->getLine(),
                'file' => $exception->getFile(),
            ]);
        }
    }
}
