<?php

namespace App\Services\HelperServices;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class CacheService
{
    public function cache_all($model, string $modelName): bool
    {
        return Cache::put($modelName, $model, now()->addMinute(60));
    }

    public function cache_item($models): true
    {
        $cacheData = [];
        foreach ($models as $model) {
            $cacheData[$model->slug] = $model;
        }
        return Cache::putMany($cacheData, now()->addMinutes(60));
    }

    public function cache_delete(string $modelName): bool
    {
        return Cache::forget($modelName);
    }

    public function handleCache(Model $model, string $modelName = null): bool
    {
        $modelName = $modelName ?? $model->tableName();

        if (!Cache::has($modelName)) {
            $this->cache_all($model->all(), $modelName);
        }


        $cacheModels = Cache::get($modelName);
        if ($cacheModels) {
            $this->cache_item($cacheModels);
        }

        return true;
    }
}
