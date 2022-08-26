<?php

declare(strict_types=1);

namespace App\Orchid\Helpers\TD;

use Orchid\Screen\TD;

class IsActiveTD
{
    public static function make(string $title = null) : TD
    {
        return BoolTD::make('is_active', $title ?? null);
    }
}
