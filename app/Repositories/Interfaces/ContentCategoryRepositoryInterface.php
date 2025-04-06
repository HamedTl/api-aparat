<?php

namespace App\Repositories\Interfaces;

use App\Repositories\Contracts\BaseRepositoryInterface;

interface ContentCategoryRepositoryInterface extends BaseRepositoryInterface
{
    public function isActives();
}
