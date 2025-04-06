<?php

namespace App\Models\Categories;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Contracts\Database\Eloquent\Builder;

class ContentCategory extends Model
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
                'source' => 'category'
            ],
        ];
    }

    public static function tableName(): string
    {
        return (new static)->getTable();
    }

    public function scopeIsActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }
}
