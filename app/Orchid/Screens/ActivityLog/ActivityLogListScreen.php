<?php

declare(strict_types=1);

namespace App\Orchid\Screens\ActivityLog;

use App\Models\ActivityLog;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use JetBrains\PhpStorm\ArrayShape;

class ActivityLogListScreen extends AbstractActivityLogListScreen
{
    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    #[ArrayShape(['models' => LengthAwarePaginator::class])]
    public function query() : array
    {
        $this->authorizeList(ActivityLog::class);

        return [
            'models' => $this
                ->getBuilder()
                ->paginate(30),
        ];
    }
}
