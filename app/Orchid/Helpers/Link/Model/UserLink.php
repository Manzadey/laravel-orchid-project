<?php

declare(strict_types=1);

namespace App\Orchid\Helpers\Link\Model;

use App\Models\User;
use Orchid\Screen\Actions\Link;

class UserLink
{
    public static function make() : Link
    {
        return Link::make(__('model.users'))
            ->icon('user')
            ->can('list', User::class);
    }
}
