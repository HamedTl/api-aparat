<?php

namespace App\Repositories\Eloquents;

use App\Models\Interactions\Channel;
use App\Models\Interactions\Like;
use App\Models\Interactions\Story;
use App\Models\Interactions\Video;
use App\Repositories\Interfaces\LikeRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Mockery\Exception;

class LikeRepository implements LikeRepositoryInterface
{
    public function toggleLike($model, $type)
    {
        $user = request()->user();
        $existingLike = $model->likes()->where('user_id', $user->id)->first();

        if ($existingLike) {
            if ($existingLike->type === $type) {
                $existingLike->delete();
                return null;
            } else {
                $existingLike->update(['type' => $type]);
                return $existingLike;
            }
        }

        return $model->likes()->create([
            'user_id' => $user->id,
            'type' => $type,
        ]);
    }
}
