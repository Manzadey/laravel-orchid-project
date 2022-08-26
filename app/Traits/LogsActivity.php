<?php

declare(strict_types=1);

namespace App\Traits;

use Spatie\Activitylog\LogOptions;

trait LogsActivity
{
    use \Spatie\Activitylog\Traits\LogsActivity;

    public function getActivityLogOptions() : LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('models')
            ->logFillable()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->logExcept(['updated_at', 'created_at']);
    }
}
