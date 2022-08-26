<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;
use App\Orchid\Services\PlatformPermissionService;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    public function list(User $user) : bool
    {
        return $user->hasAccess(PlatformPermissionService::getPermission(Role::class, 'list'));
    }

    public function show(User $user) : bool
    {
        return $user->hasAccess(PlatformPermissionService::getPermission(Role::class, 'show'));
    }

    public function create(User $user) : bool
    {
        return $user->hasAccess(PlatformPermissionService::getPermission(Role::class, 'create'));
    }

    public function edit(User $user) : bool
    {
        return $user->hasAccess(PlatformPermissionService::getPermission(Role::class, 'edit'));
    }

    public function delete(User $user, Role $role) : bool
    {
        return $role->users_count === 0 &&
            $user->hasAccess(PlatformPermissionService::getPermission(Role::class, 'delete'));
    }
}
