<?php

declare(strict_types=1);

namespace App\Orchid\Helpers\Screen;

use Illuminate\Database\Eloquent\Model;

abstract class ModelScreen extends Screen
{
    protected Model $model;

    protected function model(Model $model) : iterable
    {
        $this->model = $model;

        return compact('model');
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    protected function authorizeShow(Model $model) : void
    {
        $this->authorize('show', $model);
    }
}
