<?php

declare(strict_types=1);

namespace App\Orchid\Helpers\Sight;

use Orchid\Screen\Sight;

class UpdatedAtSight
{
    public static function make() : Sight
    {
        return TimestampSight::make('updated_at', attrName('updated_at'));
    }
}
