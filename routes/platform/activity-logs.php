<?php

declare(strict_types=1);

use App\Models\ActivityLog;
use App\Orchid\Screens\ActivityLog\ActivityLogListScreen;
use App\Orchid\Screens\ActivityLog\ActivityLogShowScreen;
use Tabuna\Breadcrumbs\Trail;

Route::screen('', ActivityLogListScreen::class)
    ->name('list')
    ->breadcrumbs(static fn(Trail $trail) : Trail => $trail
        ->parent('platform.index')
        ->push(__('Лог активности'), route('platform.activity-logs.list'))
    );

Route::screen('{activityLog}', ActivityLogShowScreen::class)
    ->name('show')
    ->breadcrumbs(static fn(Trail $trail, ActivityLog $activityLog) : Trail => $trail
        ->parent('platform.activity-logs.list')
        ->push($activityLog->name_for_human, route('platform.activity-logs.show', $activityLog))
    );
