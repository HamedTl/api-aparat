<?php

namespace App\Providers;

use App\Repositories\Eloquents\ChannelRepository;
use App\Repositories\Eloquents\CommentRepository;
use App\Repositories\Eloquents\ContentCategoryRepository;
use App\Repositories\Eloquents\LikeRepository;
use App\Repositories\Eloquents\StoryRepository;
use App\Repositories\Eloquents\SubscriptionRepository;
use App\Repositories\Eloquents\UserRepository;
use App\Repositories\Eloquents\VideoRepository;
use App\Repositories\Eloquents\ViewRepository;
use App\Repositories\Interfaces\ChannelRepositoryInterface;
use App\Repositories\Interfaces\CommentsRepositoryInterface;
use App\Repositories\Interfaces\ContentCategoryRepositoryInterface;
use App\Repositories\Interfaces\LikeRepositoryInterface;
use App\Repositories\Interfaces\StoryRepositoryInterface;
use App\Repositories\Interfaces\SubscriptionRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Interfaces\VideoRepositoryInterface;
use App\Repositories\Interfaces\ViewRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(ContentCategoryRepositoryInterface::class, ContentCategoryRepository::class);
        $this->app->bind(ChannelRepositoryInterface::class, ChannelRepository::class);
        $this->app->bind(VideoRepositoryInterface::class, VideoRepository::class);
        $this->app->bind(StoryRepositoryInterface::class, StoryRepository::class);
        $this->app->bind(CommentsRepositoryInterface::class, CommentRepository::class);
        $this->app->bind(ViewRepositoryInterface::class, ViewRepository::class);
        $this->app->bind(LikeRepositoryInterface::class, LikeRepository::class);
        $this->app->bind(SubscriptionRepositoryInterface::class, SubscriptionRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
