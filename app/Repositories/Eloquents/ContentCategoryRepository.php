<?php

namespace App\Repositories\Eloquents;

use App\Models\Categories\ContentCategory;
use App\Repositories\Interfaces\ContentCategoryRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class ContentCategoryRepository extends BaseRepository implements ContentCategoryRepositoryInterface
{
    public function __construct(ContentCategory $model)
    {
        parent::__construct($model);
    }

    public function model(): ContentCategory
    {
        return new ContentCategory();
    }

    public function isActives()
    {
        return ContentCategory::isActive()->get();
    }
}
