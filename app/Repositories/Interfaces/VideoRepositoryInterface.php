<?php

namespace App\Repositories\Interfaces;

use App\Models\Interactions\Channel;
use App\Models\Interactions\Video;

interface VideoRepositoryInterface
{
    public function model();
    public function all();

    public function show(Channel $channel, Video $video);

    public function find(Video $video);

    public function store(array $data);

    public function update(Channel $channel, Video $video, array $data);
    public function destroy(Channel $channel, Video $video);

    public function contentActions(Channel $channel, Video $video);
}
