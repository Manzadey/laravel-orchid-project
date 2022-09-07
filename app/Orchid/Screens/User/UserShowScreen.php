<?php

declare(strict_types=1);

namespace App\Orchid\Screens\User;

use App\Models\User;
use Manzadey\LaravelOrchidHelpers\Orchid\Helpers\Layouts\ModelLegendLayout;
use Manzadey\LaravelOrchidHelpers\Orchid\Helpers\Layouts\ModelMetricLayout;
use Manzadey\LaravelOrchidHelpers\Orchid\Helpers\Links\DeleteLink;
use Manzadey\LaravelOrchidHelpers\Orchid\Helpers\Links\DropdownOptions;
use Manzadey\LaravelOrchidHelpers\Orchid\Helpers\Links\EditLink;
use Manzadey\LaravelOrchidHelpers\Orchid\Helpers\Screens\ModelScreen;
use Manzadey\LaravelOrchidHelpers\Orchid\Helpers\Sights\CreatedAtSight;
use Manzadey\LaravelOrchidHelpers\Orchid\Helpers\Sights\IdSight;
use Manzadey\LaravelOrchidHelpers\Orchid\Helpers\Sights\TimestampSight;
use Manzadey\LaravelOrchidHelpers\Orchid\Helpers\Sights\UpdatedAtSight;
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
