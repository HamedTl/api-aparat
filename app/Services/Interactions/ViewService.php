<?php

namespace App\Services\Interactions;

use App\Models\Interactions\Channel;
use App\Models\Interactions\View;
use App\Repositories\Interfaces\ViewRepositoryInterface;
use App\Services\HelperServices\CacheService;
use Illuminate\Database\Eloquent\Model;

class ViewService
{
    public function __construct(
        protected ViewRepositoryInterface $viewRepository,
        protected CacheService $cacheService
    )
    {
    }

    public function create(Channel $channel, Model $model)
    {
        $view = $this->viewRepository->store([], $channel, $model);
        $this->cacheService->handleCache($this->viewRepository->model($model));
        return $view;
    }
}
