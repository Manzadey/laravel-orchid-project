<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\User;
use App\Orchid\Services\PlatformPermissionService;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function list(User $user) : bool
    {
        return $user->hasAccess(PlatformPermissionService::getPermission(User::class, 'list'));
    }

    public function show(User $user) : bool
    {
        return $user->hasAccess(PlatformPermissionService::getPermission(User::class, 'show'));
    }

    public function create(User $user) : bool
    {
        return $user->hasAccess(PlatformPermissionService::getPermission(User::class, 'create'));
    }

    public function edit(User $user) : bool
    {
        return $user->hasAccess(PlatformPermissionService::getPermission(User::class, 'edit'));
    }

    public function delete(User $user, User $userModel) : bool
    {
        return $user->isNot($userModel) && $user->hasAccess(PlatformPermissionService::getPermission(User::class, 'delete'));
    }
}
