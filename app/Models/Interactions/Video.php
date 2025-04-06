<?php

namespace App\Models\Interactions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Video extends Model
{
    protected $guarded = [];

    public function getRouteKeyName(): string
    {
        return "tag";
    }

    public static function tableName(): string
    {
        return (new static)->getTable();
    }

    public function channel(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Channel::class, 'publisher', 'channel_name');
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function views(): MorphMany
    {
        return $this->morphMany(View::class, 'viewable');
    }

    public function likes(): MorphMany
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function dislikes(): MorphMany
    {
        return $this->morphMany(Like::class, 'likeable')->where('type', 'dislike');
    }

    public function likesCount(): int
    {
        return $this->likes()->where('type', 'like')->count();
    }

    public function dislikesCount(): int
    {
        return $this->dislikes()->where('type', 'dislike')->count();
    }
}
