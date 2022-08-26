<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Role;

use App\Models\Role;
use App\Orchid\Helpers\Layouts\ModelsTableLayout;
use App\Orchid\Helpers\Link\CreateLink;
use App\Orchid\Helpers\Link\DeleteLink;
use App\Orchid\Helpers\Link\DropdownOptions;
use App\Orchid\Helpers\Link\EditLink;
use App\Orchid\Helpers\Link\ShowLink;
use App\Orchid\Helpers\Screen\AbstractListScreen;
use App\Orchid\Helpers\Screen\DestroyAction;
use App\Orchid\Helpers\TD\ActionsTD;
use App\Orchid\Helpers\TD\CountTD;
use App\Orchid\Helpers\TD\CreatedAtTD;
use App\Orchid\Helpers\TD\IdTD;
use App\Orchid\Helpers\TD\NameTD;
use App\Orchid\Helpers\TD\UpdateAtTD;
use JetBrains\PhpStorm\ArrayShape;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\TD;

class RoleListScreen extends AbstractListScreen
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
