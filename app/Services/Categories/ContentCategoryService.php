<?php

namespace App\Services\Categories;

use App\Repositories\Interfaces\ContentCategoryRepositoryInterface;
use App\Services\HelperServices\CacheService;
use Illuminate\Support\Facades\Cache;

class ContentCategoryService
{

    public function __construct(
        protected ContentCategoryRepositoryInterface $contentCategoryRepository,
        protected CacheService $cacheService,
    )
    {
    }

    public function all()
    {
        return $this->contentCategoryRepository->all();
    }

    public function activatedCategories()
    {
        return $this->contentCategoryRepository->isActives();
    }

    public function create(object $data)
    {
        $this->cacheService->handleCache($this->contentCategoryRepository->model());
        return $this->contentCategoryRepository->store([
            'category' => $data->category,
        ]);
    }

    public function show(string $slug)
    {
        return $this->contentCategoryRepository->find($slug);
    }

    public function update(string $slug, object $data)
    {
        $this->cacheService->handleCache($this->contentCategoryRepository->model());
        return $this->contentCategoryRepository->update($slug, [
            'category'=> $data->category,
        ]);
    }

    public function activateCategory(string $slug)
    {
        $this->cacheService->handleCache($this->contentCategoryRepository->model());
        return $this->contentCategoryRepository->update($slug, [
            'is_active' => true,
        ]);
    }

    public function deactivateCategory(string $slug)
    {
        $this->cacheService->handleCache($this->contentCategoryRepository->model());
        return $this->contentCategoryRepository->update($slug, [
            'is_active' => false,
        ]);
    }

    public function delete(string $slug)
    {
        $this->cacheService->handleCache($this->contentCategoryRepository->model());
        return $this->contentCategoryRepository->delete($slug);
    }
}
