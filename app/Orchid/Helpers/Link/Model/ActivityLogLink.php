<?php

declare(strict_types=1);

namespace App\Orchid\Helpers\Link\Model;

use App\Models\ActivityLog;
use Orchid\Screen\Actions\Link;

class ActivityLogLink
{
    public static function make() : Link
    {
        return Link::make(__('model.activities'))
            ->icon('cs.activity')
            ->can('list', ActivityLog::class);
    }
}
