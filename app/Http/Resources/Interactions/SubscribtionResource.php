<?php

namespace App\Http\Resources\Interactions;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubscribtionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'username' => $this->username,
            'channel' => $this->channel,
            'subscription_at' => $this->created_at->toDateTimeString()
        ];
    }
}
