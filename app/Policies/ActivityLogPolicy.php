<?php

namespace App\Policies;

use App\Models\ActivityLog;
use App\Models\User;
use App\Orchid\Services\PlatformPermissionService;
use Illuminate\Auth\Access\HandlesAuthorization;

class ActivityLogPolicy
{
    use HandlesAuthorization;

    public function list(User $user) : bool
    {
        return $user->hasAccess(PlatformPermissionService::getPermission(ActivityLog::class, 'list'));
    }

    public function show(User $user) : bool
    {
        return $user->hasAccess(PlatformPermissionService::getPermission(ActivityLog::class, 'show'));
    }
}
