<?php

namespace App\Models\Interactions;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subscription extends Model
{
    protected $guarded = [];

    public function subscriber(): BelongsTo
    {
        return $this->belongsTo(User::class, 'username');
    }

    public function channel(): BelongsTo
    {
        return $this->belongsTo(Channel::class, 'channel_name');
    }
}
