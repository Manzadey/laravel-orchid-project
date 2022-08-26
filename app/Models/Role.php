<?php

declare(strict_types=1);

namespace App\Models;

use App\Orchid\Presenters\RolePresenter;
use App\Traits\LogsActivity;

class Role extends \Orchid\Platform\Models\Role
{
    use LogsActivity;

    public function presenter() : RolePresenter
    {
        return new RolePresenter($this);
    }
}
