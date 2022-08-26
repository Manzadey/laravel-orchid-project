<?php

declare(strict_types=1);

namespace App\Orchid\Helpers\Screen;

use Orchid\Screen\Screen as BaseScreen;
use Tabuna\Breadcrumbs\Breadcrumbs;

abstract class Screen extends BaseScreen
{
    /**
     * @throws \Throwable
     */
    public function name() : ?string
    {
        return Breadcrumbs::current()->last()->title();
    }
}
