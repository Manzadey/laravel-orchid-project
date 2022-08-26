<?php

declare(strict_types=1);

namespace App\Orchid\Helpers\Alerts;

use Alert;

class SaveAlert
{
    public static function make() : void
    {
        Alert::success('Данные сохранены!');
    }
}
