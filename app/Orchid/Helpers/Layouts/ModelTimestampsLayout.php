<?php

declare(strict_types=1);

namespace App\Orchid\Helpers\Layouts;

use App\Orchid\Helpers\Sight\CreatedAtSight;
use App\Orchid\Helpers\Sight\UpdatedAtSight;
use Orchid\Screen\Layouts\Legend;
use Orchid\Support\Facades\Layout;

class ModelTimestampsLayout
{
    public static function make() : Legend
    {
        return Layout::legend('model', [
            UpdatedAtSight::make(),
            CreatedAtSight::make(),
        ])->title(__('Даты'));
    }
}
