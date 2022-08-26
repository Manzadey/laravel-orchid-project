<?php

declare(strict_types=1);

namespace App\Orchid\Presenters;

use Laravel\Scout\Builder;
use Orchid\Screen\Contracts\Personable;
use Orchid\Screen\Contracts\Searchable;
use Orchid\Support\Presenter;

/**
 * @property \App\Models\User $entity
 */
class UserPresenter extends Presenter implements Searchable, Personable
{
    /**
     * @return string
     */
    public function label() : string
    {
        return __('Пользователи');
    }

    /**
     * @return string
     */
    public function title() : string
    {
        return $this->entity->email;
    }

    /**
     * @return string
     */
    public function subTitle() : string
    {
        return $this->entity->created_at->isoFormat('LLLL');
    }

    /**
     * @return string
     */
    public function url() : string
    {
        return route('platform.users.show', $this->entity);
    }

    public function image() : ?string
    {
        return null;
    }

    /**
     * The number of models to return for show compact search result.
     *
     * @return int
     */
    public function perSearchShow() : int
    {
        return 3;
    }

    /**
     * @param  string|null  $query
     *
     * @return Builder
     */
    public function searchQuery(string $query = null) : Builder
    {
        return $this->entity::search($query);
    }
}
