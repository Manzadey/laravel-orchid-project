<?php

declare(strict_types=1);

namespace App\Orchid\Helpers\Field;

use Orchid\Screen\Fields\Input;

class SlugInput
{
    public static function make() : Input
    {
        return Input::make('model.slug')
            ->title(attrName('slug'));
    }
}
