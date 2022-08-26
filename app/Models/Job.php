<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Job extends Model
{
    use AsSource;
    use LogsActivity;

    protected $casts = [
        'payload'  => 'json',
        'attempts' => 'int',
    ];

    protected $dates = [
        'reserved_at',
        'available_at',
        'created_at',
    ];

    public function displayName() : Attribute
    {
        return Attribute::get(
            fn() : ?string => data_get($this->payload, 'displayName')
        );
    }
}
