<?php

declare(strict_types=1);

namespace App\Orchid\Helpers\Alerts;

use Alert;

class DestroyAlert
{
    public static function make(string $message = 'Данные удалены!') : void
    {
        Alert::success($message);
    }
}
