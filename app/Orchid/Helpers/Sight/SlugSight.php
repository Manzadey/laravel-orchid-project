<?php

declare(strict_types=1);

namespace App\Orchid\Helpers\Sight;

use Orchid\Screen\Sight;

class SlugSight
{
    public static function make() : Sight
    {
        return Sight::make('slug', __('ЧПУ'));
    }
}
