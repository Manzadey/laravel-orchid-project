<?php

declare(strict_types=1);

namespace App\Orchid\Screens\User;

use App\Models\User;
use App\Orchid\Helpers\Layouts\ModelLegendLayout;
use App\Orchid\Helpers\Layouts\ModelMetricLayout;
use App\Orchid\Helpers\Link\DeleteLink;
use App\Orchid\Helpers\Link\DropdownOptions;
use App\Orchid\Helpers\Link\EditLink;
use App\Orchid\Helpers\Screen\ModelScreen;
use App\Orchid\Helpers\Sight\CreatedAtSight;
use App\Orchid\Helpers\Sight\IdSight;
use App\Orchid\Helpers\Sight\TimestampSight;
use App\Orchid\Helpers\Sight\UpdatedAtSight;
use Orchid\Screen\Sight;

/**
 * @property User $model
 */
class UserShowScreen extends ModelScreen
{
    private array $metrics = [
        'activities',
        'roles',
        'notifications',
        'actions',
    ];

    /**
     * Query data.
     *
     * @return array
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function query(User $user) : iterable
    {
        $this->authorize('show', $user);

        return $this->model($user->loadCount($this->metrics));
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name() : ?string
    {
        return $this->model->email;
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar() : iterable
    {
        return [
            DropdownOptions::make()->list([
                EditLink::makeFromModel($this->model, 'platform.users.edit'),
                DeleteLink::makeFromModel($this->model),
            ]),
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout() : iterable
    {
        return [
            ModelMetricLayout::make($this->metrics),

            ModelLegendLayout::make([
                IdSight::make(),
                Sight::make('email'),
                Sight::make('name'),
                TimestampSight::make('email_verified_at'),
                CreatedAtSight::make(),
                UpdatedAtSight::make(),
            ]),
        ];
    }
}
