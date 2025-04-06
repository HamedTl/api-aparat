<?php

namespace App\Services\Interactions;

use App\Models\Interactions\Channel;
use App\Models\Interactions\Story;
use App\Repositories\Interfaces\StoryRepositoryInterface;
use App\Services\HelperServices\CacheService;
use App\Services\HelperServices\MediaManagementService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

class StoryService
{
    public function __construct(
        protected StoryRepositoryInterface $storyRepository,
        protected CacheService $cacheService,
        protected MediaManagementService $mediaManagementService,
    )
    {}

    public function all()
    {
        return Cache::get('stories');
    }

    public function show(Channel $channel, Story $story)
    {
        return $this->storyRepository->show($channel, $story);
    }

    /**
     * @throws \Exception
     */
    public function create(object $data, $channel)
    {
        $story = [
            'file' => $data->story,
            'fileName' => time() . "_" . $data->story->getClientOriginalName(),
            'filePath' => public_path("stories/stories")
        ];

        $thumbnail = [
            'file' => $data->thumbnail,
            'fileName' => time() . "_" . $data->thumbnail->getClientOriginalName(),
            'filePath' => public_path("stories/thumbnails")
        ];

        $this->mediaManagementService->handleFile([
            $story,
            $thumbnail
        ]);

        $tag = pathinfo($story['fileName'], PATHINFO_FILENAME) . rand(10000, 10000000);

        $this->cacheService->handleCache($this->storyRepository->model());

        return $this->storyRepository->store([
            'tag' => $tag,
            'publisher' => $channel,
            'description' => $data->description,
            'thumbnail' => $thumbnail['fileName'],
            'story' => $story['fileName'],
        ]);
    }

    /**
     * @throws \Exception
     */
    public function update(Channel $channel, Story $story, object $data)
    {
        $file = $this->storyRepository->find($story);
        File::delete(public_path('storage/stories/' . $file->story));
        File::delete(public_path('storage/thumbnails/' . $file->thumbnail));

        $story = [
            'file' => $data->story,
            'fileName' => time() . "_" . $data->story->getClientOriginalName(),
            'filePath' => public_path("stories/stories")
        ];

        $thumbnail = [
            'file' => $data->thumbnail,
            'fileName' => time() . "_" . $data->thumbnail->getClientOriginalName(),
            'filePath' => public_path("stories/thumbnails")
        ];

        $this->mediaManagementService->handleFile([
            $story,
            $thumbnail
        ]);

        $tag = pathinfo($story['fileName'], PATHINFO_FILENAME) . rand(10000, 10000000);

        $this->cacheService->handleCache($this->storyRepository->model());
        return $this->storyRepository->update($channel, $story['file'], [
            'tag' => $tag,
            'description' => $data->description,
            'thumbnail' => $thumbnail['fileName'],
            'story' => $story['fileName'],
        ]);
    }

    public function delete(Channel $channel, Story $story)
    {
        $file = $this->storyRepository->find($story);
        File::delete(public_path('storage/stories/' . $file->story));
        File::delete(public_path('storage/thumbnails/' . $file->thumbnail));

        $this->cacheService->handleCache($this->storyRepository->model());
        return $this->storyRepository->destroy($channel, $story);
    }
}
