<?php

namespace App\Services\Interactions;

use App\Models\Interactions\Channel;
use App\Models\Interactions\Video;
use App\Repositories\Interfaces\VideoRepositoryInterface;
use App\Services\HelperServices\CacheService;
use App\Services\HelperServices\MediaManagementService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

class VideoService
{
    public function __construct(
        protected VideoRepositoryInterface $videoRepository,
        protected CacheService $cacheService,
        protected MediaManagementService $mediaManagementService
    )
    {
    }

    public function all()
    {
        return Cache::get('videos');
    }

    public function show(Channel $channel, Video $video)
    {
        return $this->videoRepository->show($channel, $video);
    }

    /**
     * @throws \Exception
     */
    public function create(object $data, string $channel)
    {
        $video = [
            'file' => $data->video,
            'fileName' => time() . "_" .$data->video->getClientOriginalName(),
            'filePath' => public_path('videos/videos')
        ];

        $thumbnail = [
            'file' => $data->thumbnail,
            'fileName' => time() . "_" .$data->thumbnail->getClientOriginalName(),
            'filePath' => public_path('videos/thumbnails')
        ];

        $this->mediaManagementService->handleFile([
            $video,
            $thumbnail
        ]);

        $tag = pathinfo($video['fileName'], PATHINFO_FILENAME) . "_" . rand(10000, 10000000);

        $this->cacheService->handleCache($this->videoRepository->model());
        return $this->videoRepository->store([
            'tag' => $tag,
            'publisher' => $channel,
            'title' => $data->title,
            'description' => $data->description,
            'thumbnail' => $thumbnail['fileName'],
            'video' => $video['fileName'],
        ]);
    }

    /**
     * @throws \Exception
     */
    public function update(Channel $channel, Video $video, object $data)
    {
        $file = $this->videoRepository->find($video);
        File::delete('videos/videos/' . $file->video);
        File::delete('videos/thumbnails/' . $file->thumbnail);

        $video = [
            'file' => $data->video,
            'fileName' => time() . "_" .$data->video->getClientOriginalName(),
            'filePath' => public_path('videos/videos')
        ];

        $thumbnail = [
            'file' => $data->thumbnail,
            'fileName' => time() . "_" .$data->thumbnail->getClientOriginalName(),
            'filePath' => public_path('videos/thumbnails')
        ];

        $this->mediaManagementService->handleFile([
            $video,
            $thumbnail
        ]);

        $tag = pathinfo($video['fileName'], PATHINFO_FILENAME) . "_" . rand(10000, 10000000);

        $this->cacheService->handleCache($this->videoRepository->model());
        return $this->videoRepository->update($channel, $video['file'], [
            'tag' => $tag,
            'title' => $data->title,
            'description' => $data->description,
            'thumbnail' => $thumbnail['fileName'],
            'video' => $video['fileName'],
        ]);
    }

    public function delete(Channel $channel, Video $video)
    {
        $videoFile = $this->videoRepository->find($video);
        File::delete('videos/videos/' . $videoFile->video);
        File::delete('videos/thumbnails/' . $videoFile->thumbnail);

        $this->cacheService->handleCache($this->videoRepository->model());
        return $this->videoRepository->destroy($channel, $video);
    }
}
