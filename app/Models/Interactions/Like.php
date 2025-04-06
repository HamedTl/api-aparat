<?php

namespace App\Models\Interactions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Like extends Model
{
    protected $guarded = [];

    public static function tableName(): string
    {
        return (new static)->getTable();
    }

    public function likeable(): MorphTo
    {
        return $this->morphTo();
    }
}
