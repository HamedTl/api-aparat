<?php

namespace App\Http\Resources\Categories;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContentCategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=> $this->id,
            "category_name" => $this->category,
            "category_slug" => $this->slug,
            "category_active" => $this->is_active ? "is active" : "not active",
            "created_at" => $this->created_at->toDateTimeString(),
            "updated_at"=> $this->updated_at->toDateTimeString(),
        ];
    }
}
