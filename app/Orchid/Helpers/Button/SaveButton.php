<?php

declare(strict_types=1);

namespace App\Orchid\Helpers\Button;

use Orchid\Screen\Actions\Button;
use Orchid\Support\Color;

class SaveButton
{
    public static function make() : Button
    {
        return Button::make(__('Сохранить'))
            ->icon('save')
            ->type(Color::DEFAULT())
            ->method('save');
    }
}
