<?php

namespace App\Http\Resources\Users;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "admin_id" => $this->id,
            "admin_firstname" => $this->firstname,
            "admin_lastname"=> $this->lastname,
            "admin_username" => $this->username,
            "admin_username_slug" => $this->slug,
            "admin_email"=> $this->email,
            "admin_avatar" => $this->avatar,
            "created_at" => $this->created_at->toDateTimeString(),
            "updated_at"=> $this->updated_at->toDateTimeString(),
        ];
    }
}
