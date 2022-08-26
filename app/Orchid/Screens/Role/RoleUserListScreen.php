<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Role;

use App\Models\Role;
use App\Orchid\Screens\User\AbstractUserListScreen;
use JetBrains\PhpStorm\ArrayShape;

class RoleUserListScreen extends AbstractUserListScreen
{
    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    #[ArrayShape(['models' => "\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection"])]
    public function query(Role $role) : array
    {
        $this->authorize('show', $role);

        return [
            'models' => $this
                ->getBuilder(
                    $role->users()->getQuery()
                )
                ->get(),
        ];
    }
}
