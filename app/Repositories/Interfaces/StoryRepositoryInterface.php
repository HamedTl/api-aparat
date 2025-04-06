<?php

namespace App\Repositories\Interfaces;

use App\Models\Interactions\Channel;
use App\Models\Interactions\Story;

interface StoryRepositoryInterface
{
    public function model();
    public function all();
    public function show(Channel $channel, Story $story);
    public function find(Story $story);
    public function store(array $data);
    public function update(Channel $channel, Story $story, array $data);
    public function destroy(Channel $channel, Story $story);
    public function contentActions(Channel $channel, Story $story);
}
