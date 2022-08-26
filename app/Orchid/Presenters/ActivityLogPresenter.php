<?php

declare(strict_types=1);

namespace App\Orchid\Presenters;

use Orchid\Screen\Contracts\Personable;
use Orchid\Support\Presenter;

/**
 * @property \App\Models\ActivityLog $entity
 */
class ActivityLogPresenter extends Presenter implements Personable
{
    public function title() : string
    {
        $title = $this->entity->event_name;

        if($this->entity->causer) {
            $title .= ". {$this->entity->causer->email}";
        }

        return $title;
    }

    public function subTitle() : string
    {
        return $this->entity->created_at_human;
    }

    public function url() : string
    {
        return route('platform.activity-logs.show', $this->entity);
    }

    public function image() : ?string
    {
        return null;
    }
}
