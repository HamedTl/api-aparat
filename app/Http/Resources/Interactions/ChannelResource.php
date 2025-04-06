<?php

namespace App\Http\Resources\Interactions;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChannelResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'channel_id' => $this->id,
            'channel_name' => $this->channel_name,
            'channel_slug' => $this->slug,
            'channel_owner' => $this->owner_user,
            'channel_active' => $this->is_active ? "channel is active" : "channel is not active",
            'channel_avatar' => $this->avatar,
            'channel_createdAt' => $this->created_at->toDateTimeString(),
            'channel_updatedAt' => $this->updated_at->toDateTimeString(),
            'channel_videos' => $this->videos->map(function ($video) {
                return [
                    'video_id' => $video->id,
                    'video_publisher' => $video->publisher,
                    'video_title' => $video->title,
                    'video_description' => $video->description,
                    'video_thumbnail' => $video->thumbnail,
                    'video_link' => $video->video,
                    'video_created_at' => $video->created_at->toDateTimeString(),
                    'video_updated_at' => $video->updated_at->toDateTimeString(),
                ];
            }),
            'channel_stories' => $this->stories->map(function ($story) {
                return [
                    'story_id' => $story->id,
                    'story_publisher' => $story->publisher,
                    'story_description' => $story->description,
                    'story_thumbnail' => $story->thumbnail,
                    'story_link' => $story->story,
                    'story_created_at' => $story->created_at->toDateTimeString(),
                    'story_updated_at' => $story->updated_at->toDateTimeString(),
                ];
            }),
        ];
    }
}
