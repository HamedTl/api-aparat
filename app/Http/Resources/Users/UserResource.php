<?php

namespace App\Http\Resources\Users;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_firstname' => $this->firstname,
            'user_lastname' => $this->lastname,
            'user_username' => $this->username,
            'user_username_slug' => $this->slug,
            'user_email' => $this->email,
            'user_avatar' => $this->avatar,
            'user_subscribers' => $this->subscription,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
