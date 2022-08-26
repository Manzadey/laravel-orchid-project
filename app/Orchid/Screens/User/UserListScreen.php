<?php

declare(strict_types=1);

namespace App\Orchid\Screens\User;

use App\Models\User;
use App\Orchid\Helpers\Link\CreateLink;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use JetBrains\PhpStorm\ArrayShape;

class UserListScreen extends AbstractUserListScreen
{
    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    #[ArrayShape(['models' => LengthAwarePaginator::class])]
    public function query() : array
    {
        $this->authorizeList(User::class);

        return [
            'models' => $this
                ->getBuilder()
                ->paginate(30),
        ];
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar() : array
    {
        return [
            CreateLink::make()
                ->route('platform.users.create')
                ->can('create', User::class),
        ];
    }
}
