<?php

namespace App\Repositories\Eloquents;

use App\Models\Interactions\Channel;
use App\Models\Interactions\Video;
use App\Repositories\Interfaces\VideoRepositoryInterface;

class VideoRepository implements VideoRepositoryInterface
{

    public function model(): Video
    {
        return new Video();
    }

    public function all(): \Illuminate\Database\Eloquent\Collection
    {
        return Video::all();
    }

    public function show(Channel $channel, Video $video): Video
    {
        return $video;
    }

    public function find(Video $video): Video
    {
        return $video;
    }

    public function store(array $data)
    {
        return Video::create($data);
    }

    public function update(Channel $channel, Video $video, array $data): bool
    {
        return $video->update($data);
    }

    public function destroy(Channel $channel, Video $video): ?bool
    {
        return $video->delete();
    }

    public function contentActions(Channel $channel, Video $video): Video
    {
        return $video->load('comments');
    }
}
