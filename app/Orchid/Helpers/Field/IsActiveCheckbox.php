<?php

declare(strict_types=1);

namespace App\Orchid\Helpers\Field;

use Orchid\Screen\Fields\CheckBox;

class IsActiveCheckbox
{
    public static function make() : CheckBox
    {
        return CheckBox::make('model.is_active')
            ->title(attrName('is_active'))
            ->sendTrueOrFalse();
    }
}
