<?php

declare(strict_types=1);

namespace App\Orchid\Helpers\Link;

use Orchid\Screen\Actions\DropDown;

class DropdownOptions
{
    public static function make() : DropDown
    {
        return DropDown::make()->icon('options-vertical');
    }
}
