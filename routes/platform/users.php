<?php

declare(strict_types=1);

use App\Models\User;
use App\Orchid\Screens\User as UserScreen;
use Tabuna\Breadcrumbs\Trail;

Route::screen('', UserScreen\UserListScreen::class)
    ->name('list')
    ->breadcrumbs(static fn(Trail $trail) : Trail => $trail
        ->parent('platform.index')
        ->push(__('Пользователи'), route('platform.users.list'))
    );

Route::screen('create', UserScreen\UserEditScreen::class)
    ->name('create')
    ->breadcrumbs(static fn(Trail $trail) : Trail => $trail
        ->parent('platform.users.list')
        ->push(__('Добавить'), route('platform.users.create'))
    );

Route::prefix('{user}')->group(static function() {
    Route::screen('', UserScreen\UserShowScreen::class)
        ->name('show')
        ->breadcrumbs(static fn(Trail $trail, User $user) : Trail => $trail
            ->parent('platform.users.list')
            ->push($user->email, route('platform.users.show', $user))
        );

    Route::screen('edit', UserScreen\UserEditScreen::class)
        ->name('edit')
        ->breadcrumbs(static fn(Trail $trail, User $user) : Trail => $trail
            ->parent('platform.users.show', $user)
            ->push(__('Редактировать'), route('platform.users.edit', $user))
        );
});
