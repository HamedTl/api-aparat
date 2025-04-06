<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Videos\VideoStoreRequest;
use App\Http\Requests\Videos\VideoUpdateRequest;
use App\Http\Resources\Interactions\VideoResource;
use App\Models\Interactions\Channel;
use App\Models\Interactions\Video;
use App\Services\Interactions\VideoService;
use App\Services\Interactions\ViewService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;

/**
 *
 * @OA\Info (
 *     title="Videos API",
 *     version="1.0.0",
 *     description="This is videos api",
 *     @OA\Contact (
 *         email="admin@mail.com"
 *     ),
 *     @OA\License(
 *          name="MIT",
 *          url="https://opensource.org/licenses/MIT"
 *      )
 * )
 *
 */

class VideoController extends Controller
{
    public function __construct(
        protected VideoService $videoService,
        protected ViewService $viewService,
    )
    {
    }


    /**
     * @OA\Get (
     *     path="/api/channels/{channel:slug}/videos",
     *     summary="Get a list of videos for a specific channel",
     *     description="Returns a list of videos associated with a given channel SLUG",
     *     tags={"Videos"},
     *     @OA\Parameter (
     *         name="channel",
     *         in="path",
     *         description="The SLUG of the channel",
     *         required=true,
     *         @OA\Schema (type="string", example="code-learning"),
     *     ),
     *     @OA\Response (
     *         response=200,
     *         description="List of videos",
     *         @OA\JsonContent (
     *             type="object",
     *             @OA\Property (
     *                 property="status",
     *                 type="string",
     *                 example="success"
     *             ),
     *             @OA\Property (
     *                  property="message",
     *                  type="string",
     *                  example="videos"
     *              ),
     *              @OA\Property (
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(ref="#/components/schemas/VideoResource")
     *              ),
     *         ),
     *     ),
     *     @OA\Response (
     *         response=404,
     *         description="Channel not found"
     *     )
     * )
     *
     */
    public function index(): JsonResponse
    {
        return $this->sendSuccess("videos", [
            VideoResource::collection($this->videoService->all()),
        ]);
    }

    public function store(VideoStoreRequest $request, Channel $channel): JsonResponse
    {
        try {
            $request->validated();
            $video = $this->videoService->create($request, $channel->channel_name);
            return $this->sendSuccess("video created successfully", [
                $video,
            ], 201);
        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), [
                'code' => $exception->getCode(),
                'line' => $exception->getLine(),
                'file' => $exception->getFile(),
            ]);
        }
    }

    public function show(Channel $channel, Video $video): JsonResponse
    {
        $videoResponse = $this->videoService->show($channel, $video);
        $this->viewService->create($channel, $video);
        return $this->sendSuccess("video", [
            VideoResource::make($videoResponse),
        ]);
    }

    public function update(VideoUpdateRequest $request, Channel $channel, Video $video): JsonResponse
    {
        try {
            Gate::authorize('content-update', $video);
            $request->validated();
            $videoResponse = $this->videoService->update($channel, $video, $request);
            return $this->sendSuccess("video updated successfully", [
                $videoResponse,
            ]);
        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), [
                'code' => $exception->getCode(),
                'line' => $exception->getLine(),
                'file' => $exception->getFile(),
            ]);
        }
    }

    public function destroy(Channel $channel, Video $video): JsonResponse
    {
        try {
            Gate::authorize('content-delete', $video);
            $videoResponse = $this->videoService->delete($channel, $video);
            return $this->sendSuccess("video deleted successfully", [
                $videoResponse,
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
