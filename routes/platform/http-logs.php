<?php

declare(strict_types=1);

use App\Orchid\Screens\HttpLog\HttpLogListScreen;
use App\Orchid\Screens\HttpLog\HttpLogShowScreen;
use DragonCode\LaravelHttpLogger\Models\HttpLog;
use Tabuna\Breadcrumbs\Trail;

Route::screen('', HttpLogListScreen::class)
    ->name('list')
    ->breadcrumbs(static fn(Trail $trail) : Trail => $trail
        ->parent('platform.index')
        ->push(__('model.http-logs'), route('platform.http-logs.list'))
    );

Route::screen('{httpLog}', HttpLogShowScreen::class)
    ->name('show')
    ->breadcrumbs(static fn(Trail $trail, HttpLog $httpLog) : Trail => $trail
        ->parent('platform.http-logs.list')
        ->push($httpLog->path, route('platform.http-logs.show', $httpLog->name))
    );
