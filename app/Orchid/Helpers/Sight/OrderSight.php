<?php

declare(strict_types=1);

namespace App\Orchid\Helpers\Sight;

use Orchid\Screen\Sight;

class OrderSight
{
    public static function make() : Sight
    {
        return Sight::make('order', attrName('order'));
    }
}
