<?php

namespace App\Orchid\Presenters;

use Orchid\Screen\Contracts\Personable;
use Orchid\Support\Presenter;

/**
 * @property \App\Models\Role $entity
 */
class RolePresenter extends Presenter implements Personable
{
    public function title() : string
    {
        return $this->entity->name;
    }

    public function subTitle() : string
    {
        return '';
    }

    public function url() : string
    {
        return route('platform.roles.show', $this->entity);
    }

    public function image() : ?string
    {
        return null;
    }
}
