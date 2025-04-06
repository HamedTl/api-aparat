<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Categories\ContentCategoryStoreRequest;
use App\Http\Requests\Categories\ContentCategoryUpdateRequest;
use App\Http\Resources\Categories\ContentCategoryResource;
use App\Services\Categories\ContentCategoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ContentCategoryController extends Controller
{

    public function __construct(protected ContentCategoryService $contentCategoryService)
    {
        Gate::authorize('is-admin');
    }

    public function index(): JsonResponse
    {
        return $this->sendSuccess("all categories", [
            ContentCategoryResource::collection($this->contentCategoryService->all()),
        ]);
    }

    public function store(ContentCategoryStoreRequest $request): JsonResponse
    {
        try {
            $request->validated();
            $category = $this->contentCategoryService->create($request);

            return $this->sendSuccess("category created successfully", [
                $category
            ], 201);
        } catch (\Exception $e) {
            return $this->sendError("have an error in store processing", [
                $e->getMessage(),
            ]);
        }
    }

    public function show(string $slug): JsonResponse
    {
        return $this->sendSuccess("category", [
            new ContentCategoryResource($this->contentCategoryService->show($slug)),
        ]);
    }

    public function update(ContentCategoryUpdateRequest $request, string $slug): JsonResponse
    {
        try {
            $request->validated();
            $category = $this->contentCategoryService->update($slug, $request);

            return $this->sendSuccess("category updated successfully", [
                $category,
            ]);
        } catch (\Exception $e) {
            return $this->sendError("have an error in update processing", [
                $e->getMessage(),
            ]);
        }
    }

    public function destroy(string $slug): JsonResponse
    {
        try {
            $category = $this->contentCategoryService->delete($slug);

            return $this->sendSuccess("category deleted successfully", [
                $category,
            ]);
        } catch (\Exception $e) {
            return $this->sendError("have an error in destroy processing", [
                $e->getMessage(),
            ]);
        }
    }
}
