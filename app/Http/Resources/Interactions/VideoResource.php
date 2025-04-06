<?php

namespace App\Http\Resources\Interactions;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


/**
 * @OA\Schema(
 *     schema="VideoResource",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="tag", type="string", example="1735760898_laravel_part_94_8213544"),
 *     @OA\Property(property="publisher", type="string", example="Code Learning"),
 *     @OA\Property(property="title", type="string", example="Sample Video"),
 *     @OA\Property(property="description", type="string", example="Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum "),
 *     @OA\Property(property="thumbnail", type="string", example="https://example.com/videos/thumbnails/1735760898_Network.jpg"),
 *     @OA\Property(property="source", type="string", example="https://example.com/videos/videos/1735760898_laravel_part_94.mp4"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2025-01-10T12:34:56Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-01-10T12:34:56Z")
 * )
 */

class VideoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'video_id' => $this->id,
            'video_tag' => $this->tag,
            'video_publisher' => $this->publisher,
            'video_title' => $this->title,
            'video_description' => $this->description,
            'video_thumbnail' => $this->thumbnail,
            'video_source' => $this->video,
            'video_createdAt' => $this->created_at->toDateTimeString(),
            'video_updatedAt' => $this->updated_at->toDateTimeString(),
            'video_views' => $this->views->map(fn ($view) => $view->views),
            'video_likes' => $this->likesCount(),
            'video_dislikes' => $this->dislikesCount(),
            'video_comments' => $this->comments->map(function ($comment) {
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
