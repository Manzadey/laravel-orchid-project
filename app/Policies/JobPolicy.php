<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Job;
use App\Models\User;
use App\Orchid\Services\PlatformPermissionService;
use Illuminate\Auth\Access\HandlesAuthorization;

class JobPolicy
{
    use HandlesAuthorization;

    public function list(User $user) : bool
    {
        return $user->hasAccess(PlatformPermissionService::getPermission(Job::class, 'list'));
    }

    public function show(User $user) : bool
    {
        return $user->hasAccess(PlatformPermissionService::getPermission(Job::class, 'show'));
    }
}
