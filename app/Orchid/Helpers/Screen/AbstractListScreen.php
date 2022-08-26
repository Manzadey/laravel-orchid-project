<?php

declare(strict_types=1);

namespace App\Orchid\Helpers\Screen;

abstract class AbstractListScreen extends Screen
{
    protected bool $hasModels = false;

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    protected function authorizeList(string $model) : void
    {
        $this->authorize('list', $model);
    }
}
