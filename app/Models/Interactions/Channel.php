<?php

namespace App\Models\Interactions;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Channel extends Model
{
    use Sluggable;

    protected $guarded = [];

    public function getRouteKeyName(): string
    {
        return "slug";
    }

    public function sluggable(): array
    {
        return [
            "slug"=> [
                "source" => "channel_name"
            ]
        ];
    }

    public static function tableName(): string
    {
        return (new static)->getTable();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_user', 'username');
    }

    public function videos(): HasMany
    {
        return $this->hasMany(Video::class, 'publisher', 'channel_name');
    }

    public function stories(): HasMany
    {
        return $this->hasMany(Story::class, 'publisher', 'channel_name');
    }

    public function subscribers(): HasMany
    {
        return $this->hasMany(Subscription::class, 'channel_name');
    }

}
