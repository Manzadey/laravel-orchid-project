<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Role;

use App\Models\Role;
use App\Orchid\Helpers\Link\Model\ActivityLogLink;
use App\Orchid\Helpers\Link\Model\UserLink;
use Manzadey\LaravelOrchidHelpers\Orchid\Helpers\Layouts\ModelLegendLayout;
use Manzadey\LaravelOrchidHelpers\Orchid\Helpers\Layouts\ModelMetricLayout;
use Manzadey\LaravelOrchidHelpers\Orchid\Helpers\Layouts\ModelTimestampsLayout;
use Manzadey\LaravelOrchidHelpers\Orchid\Helpers\Links\DeleteLink;
use Manzadey\LaravelOrchidHelpers\Orchid\Helpers\Links\DropdownOptions;
use Manzadey\LaravelOrchidHelpers\Orchid\Helpers\Links\DropdownRelations;
use Manzadey\LaravelOrchidHelpers\Orchid\Helpers\Links\EditLink;
use Manzadey\LaravelOrchidHelpers\Orchid\Helpers\Screens\ModelScreen;
use Manzadey\LaravelOrchidHelpers\Orchid\Helpers\Sights\PrintSight;
use Manzadey\LaravelOrchidHelpers\Orchid\Helpers\Sights\Sight;

/**
 * @property Role $model
 */
class RoleShowScreen extends ModelScreen
{
    private array $metrics = [
        'activities',
        'users',
    ];

    /**
     * Query data.
     *
     * @return array
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function query(Role $role) : iterable
    {
        $this->authorizeShow($role);

        return $this->model($role->loadCount($this->metrics));
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar() : iterable
    {
        return [
            DropdownRelations::make()->list([
                ActivityLogLink::make()
                    ->route('platform.roles.activities', $this->model),

                UserLink::make()
                    ->route('platform.roles.users', $this->model),
            ]),

            DropdownOptions::make()->list([
                EditLink::makeFromModel($this->model, 'platform.roles.edit'),
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
                Sight::make('name'),
                Sight::make('slug'),
                PrintSight::make('permissions'),
            ]),

            ModelTimestampsLayout::make(),
        ];
    }
}
