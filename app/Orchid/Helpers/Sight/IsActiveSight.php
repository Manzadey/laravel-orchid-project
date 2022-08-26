<?php

declare(strict_types=1);

namespace App\Orchid\Helpers\Sight;

class IsActiveSight
{
    public static function make() : \Orchid\Screen\Sight
    {
        return BoolSight::make('is_active');
    }
}
