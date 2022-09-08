<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Role;

use App\Models\Role;
use App\Orchid\Screens\Activity\AbstractActivityListScreen;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use JetBrains\PhpStorm\ArrayShape;

class RoleActivityLogListScreen extends AbstractActivityListScreen
{
    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    #[ArrayShape(['models' => LengthAwarePaginator::class])]
    public function query(Role $role) : array
    {
        $this->authorize('show', $role);

        return [
            'models' => $this
                ->getBuilder(
                    $role->activities()->getQuery()
                )
                ->paginate(30),
        ];
    }
}
