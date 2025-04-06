<?php

namespace App\Http\Resources\Interactions;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'story_id' => $this->id,
            'story_tag' => $this->tag,
            'story_publisher' => $this->publisher,
            'story_description' => $this->description,
            'story_thumbnail' => $this->thumbnail,
            'story' => $this->story,
            'story_createdAt' => $this->created_at->toDateTimeString(),
            'story_updatedAt' => $this->updated_at->toDateTimeString(),
            'story_views' => $this->views->map(fn ($view) => $view->views),
            'story_likes' => $this->likesCount(),
            'story_dislikes' => $this->dislikesCount(),
            'story_comments' => $this->comments->map(function ($comment) {
                return [
                    'username' => $comment->username,
                    'comment' => $comment->comment,
                    'created_at' => $comment->created_at->toDateTimeString(),
                    'updated_at' => $comment->updated_at->toDateTimeString(),
                ];
            })
        ];
    }
}
