<?php

namespace App\Models\Interactions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class View extends Model
{
    protected $guarded = [];

    public static function tableName(): string
    {
        return (new static)->getTable();
    }

    public function viewable(): MorphTo
    {
        return $this->morphTo();
    }
}
