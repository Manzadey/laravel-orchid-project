<?php

declare(strict_types=1);

namespace App\Orchid\Helpers\Sight;

use Orchid\Screen\Sight as BaseSight;

class Sight
{
    public static function make(string $name, string $title = null) : BaseSight
    {
        return BaseSight::make($name, $title ?? attrName($name));
    }
}
