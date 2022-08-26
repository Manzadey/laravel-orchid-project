<?php

declare(strict_types=1);

namespace App\Orchid\Helpers\Link;

use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\Actions\Link;

class ShowLink
{
    public static function make() : Link
    {
        return Link::make(__('Подробнее'))
            ->icon('eye');
    }

    public static function makeFromModel(Model $model, string $route) : Link
    {
        return self::make()
            ->route($route, $model)
            ->can('show', $model);
    }
}
