<?php

declare(strict_types=1);

namespace App\Orchid\Helpers\Link;

use Orchid\Screen\Actions\DropDown;

class DropdownRelations
{
    public static function make() : DropDown
    {
        return DropDown::make(__('Связи'))
            ->icon('share');
    }
}
