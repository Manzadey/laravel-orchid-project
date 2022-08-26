<?php

declare(strict_types=1);

namespace App\Orchid\Helpers\Field;

use Orchid\Screen\Fields\Input;

class OrderInput
{
    public static function make(string $name = 'order') : Input
    {
        return Input::make("model.$name")
            ->required()
            ->type('number')
            ->min(0)
            ->value(0)
            ->title(attrName($name));
    }
}
