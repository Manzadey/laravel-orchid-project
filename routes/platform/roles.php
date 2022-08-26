<?php

declare(strict_types=1);

use App\Models\Role;
use App\Orchid\Screens\Role as RoleScreen;
use Tabuna\Breadcrumbs\Trail;

Route::screen('', RoleScreen\RoleListScreen::class)
    ->name('list')
    ->breadcrumbs(static fn(Trail $trail) : Trail => $trail
        ->parent('platform.index')
        ->push(__('model.roles'), route('platform.roles.list'))
    );

Route::screen('create', RoleScreen\RoleEditScreen::class)
    ->name('create')
    ->breadcrumbs(static fn(Trail $trail) : Trail => $trail
        ->parent('platform.roles.list')
        ->push(__('Добавить'), route('platform.roles.create'))
    );

Route::prefix('{role}')->group(static function() : void {
    Route::screen('', RoleScreen\RoleShowScreen::class)
        ->name('show')
        ->breadcrumbs(static fn(Trail $trail, Role $role) : Trail => $trail
            ->parent('platform.roles.list')
            ->push($role->name, route('platform.roles.show', $role))
        );

    Route::screen('edit', RoleScreen\RoleEditScreen::class)
        ->name('edit')
        ->breadcrumbs(static fn(Trail $trail, Role $role) : Trail => $trail
            ->parent('platform.roles.show', $role)
            ->push($role->name, route('platform.roles.edit', $role))
        );

    Route::screen('users', RoleScreen\RoleUserListScreen::class)
        ->name('users')
        ->breadcrumbs(static fn(Trail $trail, Role $role) : Trail => $trail
            ->parent('platform.roles.show', $role)
            ->push(__('model.users'), route('platform.roles.users', $role))
        );

    Route::screen('activities', RoleScreen\RoleActivityLogListScreen::class)
        ->name('activities')
        ->breadcrumbs(static fn(Trail $trail, Role $role) : Trail => $trail
            ->parent('platform.roles.show', $role)
            ->push(__('model.activities'), route('platform.roles.activities', $role))
        );
});
