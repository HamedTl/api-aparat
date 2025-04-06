<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ContentCategoryController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Client\Comments\StoryCommentController;
use App\Http\Controllers\Client\Comments\VideoCommentController;
use App\Http\Controllers\Client\Likes\StoryLikeController;
use App\Http\Controllers\Client\Likes\VideoLikeController;
use App\Http\Controllers\Client\StoryController;
use App\Http\Controllers\Client\SubscriptionController;
use App\Http\Controllers\Client\UserController;
use App\Http\Controllers\Client\ChannelController;
use App\Http\Controllers\Client\VideoController;
use Illuminate\Support\Facades\Route;


// Authentication Routes (Registration, Login, Logout)
Route::prefix("auth")->controller(AuthController::class)->group(function () {
    Route::post('/registration', 'register')->middleware('guest');
    Route::post('/login', 'login')->middleware('guest');
    Route::post('/logout', 'logout')->middleware('auth:sanctum');
});


// Admin Panel Routes
Route::prefix('admin-panel')->middleware('auth:sanctum')->group(function () {
    // Content Category Routes
    Route::apiResource('content-categories', ContentCategoryController::class);

    // Admin Ability Route
    Route::get('/admins', [AdminController::class,'admins']);
    Route::put('/admins/active-admin-ability/{slug}', [AdminController::class, 'getAdminAbility']);
    Route::put('/admins/deactive-admin-ability/{slug}', [AdminController::class, 'takeAdminAbility']);
});


//--------------------- Client Side Routes ---------------------//


Route::middleware('auth:sanctum')->group(function () {
    // User Routes
    Route::get('/user/{user:slug}', [UserController::class, 'index']);
    Route::put('/user/edit/{user:slug}', [UserController::class, 'update']);

    // Channel Routes
    Route::apiresource('channels', ChannelController::class);

    // Video Routes
    Route::apiResource('channels.videos', VideoController::class)->scoped();

    // Story Routes
    Route::apiResource('channels.stories', StoryController::class)->scoped();

    // Comment Routes
    Route::prefix('channels/{channel}/videos/{video}/comments')->group(function () {
        Route::post('/', [VideoCommentController::class, 'store']);
        Route::put('/{comment}', [VideoCommentController::class, 'update']);
        Route::delete('/{comment}', [VideoCommentController::class, 'destroy']);
    });

    Route::prefix('channels/{channel}/stories/{story}/comments')->group(function () {
        Route::post('/', [StoryCommentController::class, 'store']);
        Route::put('/{comment}', [StoryCommentController::class, 'update']);
        Route::delete('/{comment}', [StoryCommentController::class, 'destroy']);
    });

    // Like & Dislike Routes
    Route::prefix('channels/{channel}/videos/{video:tag}')->group(function () {
        Route::post('/like', [VideoLikeController::class, 'like']);
        Route::post('/dislike', [VideoLikeController::class, 'dislike']);
    });

    Route::prefix('channels/{channel}/stories/{story:tag}')->group(function () {
        Route::post('/like', [StoryLikeController::class, 'like']);
        Route::post('/dislike', [StoryLikeController::class, 'dislike']);
    });

    // Subscription Routes
    Route::prefix('channels/{channel}')->group(function () {
        Route::get('/subscriptions', [SubscriptionController::class, 'getSubscription']);
        Route::post('/subscribe', [SubscriptionController::class, 'subscribe']);
        Route::delete('/unsubscribe', [SubscriptionController::class, 'unsubscribe']);
    });
});

