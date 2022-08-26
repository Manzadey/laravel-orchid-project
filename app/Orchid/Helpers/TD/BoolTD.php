<?php

declare(strict_types=1);

namespace App\Orchid\Helpers\TD;

use App\Models\Model;
use App\View\Components\Platform\BoolComponent;
use Orchid\Screen\Repository;
use Orchid\Screen\TD;
use Orchid\Support\Blade;

class BoolTD
{
    public static function make(string $name, string $title = null) : TD
    {
        return TD::make($name, $title ?? __("validation.attributes.model.$name"))
            ->width('66px')
            ->alignCenter()
            ->sort()
            ->render(static fn(Repository|Model $target) => self::render([
                'target' => $target,
                'name'   => $name,
            ]));
    }

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected static function render(array $data) : string
    {
        return Blade::renderComponent(BoolComponent::class, $data);
    }
}
