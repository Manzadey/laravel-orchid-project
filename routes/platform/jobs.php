<?php

declare(strict_types=1);

use App\Models\Job;
use App\Orchid\Screens\Job\JobListScreen;
use App\Orchid\Screens\Job\JobShowScreen;
use Tabuna\Breadcrumbs\Trail;

Route::screen('', JobListScreen::class)
    ->name('list')
    ->breadcrumbs(static fn(Trail $trail) : Trail => $trail
        ->parent('platform.index')
        ->push(__('model.jobs'), route('platform.jobs.list'))
    );

Route::screen('{job}', JobShowScreen::class)
    ->name('show')
    ->breadcrumbs(static fn(Trail $trail, Job $job) : Trail => $trail
        ->parent('platform.jobs.list')
        ->push($job->display_name, route('platform.jobs.show', $job))
    );
