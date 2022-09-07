<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Role;

use App\Models\Role;
use App\Orchid\Helpers\Screen\DestroyAction;
use JetBrains\PhpStorm\ArrayShape;
use Manzadey\LaravelOrchidHelpers\Orchid\Helpers\Layouts\ModelsTableLayout;
use Manzadey\LaravelOrchidHelpers\Orchid\Helpers\Links\CreateLink;
use Manzadey\LaravelOrchidHelpers\Orchid\Helpers\Links\DeleteLink;
use Manzadey\LaravelOrchidHelpers\Orchid\Helpers\Links\DropdownOptions;
use Manzadey\LaravelOrchidHelpers\Orchid\Helpers\Links\EditLink;
use Manzadey\LaravelOrchidHelpers\Orchid\Helpers\Links\ShowLink;
use Manzadey\LaravelOrchidHelpers\Orchid\Helpers\Screens\AbstractScreen;
use Manzadey\LaravelOrchidHelpers\Orchid\Helpers\TD\ActionsTD;
use Manzadey\LaravelOrchidHelpers\Orchid\Helpers\TD\CountTD;
use Manzadey\LaravelOrchidHelpers\Orchid\Helpers\TD\CreatedAtTD;
use Manzadey\LaravelOrchidHelpers\Orchid\Helpers\TD\IdTD;
use Manzadey\LaravelOrchidHelpers\Orchid\Helpers\TD\NameTD;
use Manzadey\LaravelOrchidHelpers\Orchid\Helpers\TD\UpdateAtTD;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\TD;

class RoleListScreen extends AbstractScreen
{
    use DestroyAction;

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    #[ArrayShape(['models' => 'mixed'])]
    public function query() : array
    {
        $this->authorizeList(Role::class);

        return [
            'models' => Role::withCount('users')
                ->filters()
                ->latest('id')
                ->get(),
        ];
    }

    /**
     * Button commands.
     *
     * @return Action[]
     */
    public function commandBar() : array
    {
        return [
            CreateLink::make('platform.roles.create')
                ->can('create', Role::class),
        ];
    }

    public function layout() : array
    {
        return [
            ModelsTableLayout::make([
                IdTD::make(),
                NameTD::make()
                    ->width('200px'),
                TD::make('slug', attrName('slug'))
                    ->width('200px'),
                CountTD::make('users', __('model.users')),
                UpdateAtTD::make(),
                CreatedAtTD::make(),
                ActionsTD::make(static fn(Role $role) : DropDown => DropdownOptions::make()->list([
                    ShowLink::makeFromModel($role, 'platform.roles.show'),
                    EditLink::makeFromModel($role, 'platform.roles.edit'),
                    DeleteLink::makeFromModel($role),
                ])),
            ]),
        ];
    }
}
