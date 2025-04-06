<?php

namespace App\Providers;

use App\Policies\AdminPermissionPolicy;
use App\Policies\ChannelPolicy;
use App\Policies\CommentPolicy;
use App\Policies\ContentPolicy;
use App\Policies\UserContentPermissionPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthorizationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Admin Policies
        Gate::define('is-admin', [AdminPermissionPolicy::class,'isAdmin']);

        // Channel Policies
        Gate::define('channel-update', [ChannelPolicy::class, 'update']);
        Gate::define('channel-delete', [ChannelPolicy::class, 'delete']);

        // Comment Policies
        Gate::define('comment-update', [CommentPolicy::class, 'update']);
        Gate::define('comment-delete', [CommentPolicy::class, 'delete']);

        // Content Policies
        Gate::define('content-update', [ContentPolicy::class, 'update']);
        Gate::define('content-delete', [ContentPolicy::class, 'delete']);
    }
}
