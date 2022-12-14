<?php

declare(strict_types=1);

use App\Orchid\Screens\PlatformScreen;
use App\Orchid\Screens\StorageLogScreen;
use App\Orchid\Screens\User\UserProfileScreen;
use Manzadey\OrchidHttpLog\Http\Middleware\HttpLogMiddleware;
use Tabuna\Breadcrumbs\Trail;

Route::middleware(HttpLogMiddleware::class)
    ->name('platform.')
    ->group(static function() {
        Route::screen('main', PlatformScreen::class)
            ->name('main');

        Route::screen('profile', UserProfileScreen::class)
            ->name('profile')
            ->breadcrumbs(static fn(Trail $trail) : Trail => $trail
                ->parent('platform.index')
                ->push(__('Profile'), route('platform.profile'))
            );

        Route::prefix('users')
            ->name('users.')
            ->group(base_path('routes/platform/users.php'));

        Route::prefix('roles')
            ->name('roles.')
            ->group(base_path('routes/platform/roles.php'));

        Route::prefix('activities')
            ->name('activities.')
            ->group(base_path('routes/platform/activities.php'));

        Route::prefix('http-logs')
            ->name('http-logs.')
            ->group(base_path('routes/platform/http-logs.php'));

        Route::prefix('jobs')
            ->name('jobs.')
            ->group(base_path('routes/platform/jobs.php'));

        Route::screen('storage-logs', StorageLogScreen::class)
            ->name('storage-logs')
            ->breadcrumbs(static fn(Trail $trail) : Trail => $trail
                ->parent('platform.index')
                ->push(__('Системные логи'), route('platform.storage-logs'))
            );
    });
