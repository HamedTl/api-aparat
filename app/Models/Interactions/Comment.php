<?php

namespace App\Models\Interactions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Comment extends Model
{
    protected $guarded = [];

    public function getRouteKeyName(): string
    {
        return 'id';
    }

    public static function tableName(): string
    {
        return (new static)->getTable();
    }

    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }
}
