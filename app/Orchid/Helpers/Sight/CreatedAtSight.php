<?php

declare(strict_types=1);

namespace App\Orchid\Helpers\Sight;

use Orchid\Screen\Sight;

class CreatedAtSight
{
    public static function make() : Sight
    {
        return TimestampSight::make('created_at', attrName('created_at'));
    }
}
