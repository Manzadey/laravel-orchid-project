<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\HttpLog;
use App\Models\User;
use App\Orchid\Services\PlatformPermissionService;
use Illuminate\Auth\Access\HandlesAuthorization;

class HttpLogPolicy
{
    use HandlesAuthorization;

    public function list(User $user) : bool
    {
        return $user->hasAccess(PlatformPermissionService::getPermission(HttpLog::class, 'list'));
    }

    public function show(User $user) : bool
    {
        return $user->hasAccess(PlatformPermissionService::getPermission(HttpLog::class, 'show'));
    }
}
