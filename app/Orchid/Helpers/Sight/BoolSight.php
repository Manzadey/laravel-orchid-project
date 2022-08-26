<?php

declare(strict_types=1);

namespace App\Orchid\Helpers\Sight;

use App\View\Components\Platform\BoolComponent;
use Orchid\Screen\Sight;

class BoolSight
{
    public static function make(string $name, string $title = null) : Sight
    {
        return Sight::make($name, $title ?? attrName($name))
            ->component(BoolComponent::class, compact('name'));
    }
}
