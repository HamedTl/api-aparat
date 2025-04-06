<?php

namespace App\Repositories\Eloquents;

use App\Models\Interactions\Channel;
use App\Models\Interactions\Story;
use App\Repositories\Interfaces\StoryRepositoryInterface;

class StoryRepository implements StoryRepositoryInterface
{

    public function model(): Story
    {
        return new Story();
    }

    public function all(): \Illuminate\Database\Eloquent\Collection
    {
        return Story::all();
    }

    public function show(Channel $channel, Story $story): Story
    {
        return $story;
    }

    public function find(Story $story): Story
    {
        return $story;
    }

    public function store(array $data)
    {
        return Story::create($data);
    }

    public function update(Channel $channel, Story $story, array $data): bool
    {
        return $story->update($data);
    }

    public function destroy(Channel $channel, Story $story): ?bool
    {
        return $story->delete();
    }

    public function contentActions(Channel $channel, Story $story): Story
    {
        return $story->load('comments');
    }
}
