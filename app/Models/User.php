<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\LogsActivity;
use Laravel\Scout\Searchable;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\CausesActivity;

class User extends \Orchid\Platform\Models\User
{
    use Searchable;
    use LogsActivity;
    use CausesActivity;

    protected $fillable = [
        'name',
        'email',
        'password',
        'permissions',
    ];

    protected $casts = [
        'email_verified_at'    => 'datetime',
        'sent_email_verify_at' => 'datetime',
        'permissions'          => 'json',
    ];

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
