<?php

declare(strict_types=1);

namespace App\Orchid\Screens\User;

use App\Models\User;
use Manzadey\LaravelOrchidHelpers\Orchid\Helpers\Layouts\ModelsTableLayout;
use Manzadey\LaravelOrchidHelpers\Orchid\Helpers\Links\DropdownOptions;
use Manzadey\LaravelOrchidHelpers\Orchid\Helpers\Links\EditLink;
use Manzadey\LaravelOrchidHelpers\Orchid\Helpers\Links\ShowLink;
use Manzadey\LaravelOrchidHelpers\Orchid\Helpers\Screens\AbstractListScreen;
use Manzadey\LaravelOrchidHelpers\Orchid\Helpers\Screens\AbstractScreen;
use Manzadey\LaravelOrchidHelpers\Orchid\Helpers\TD\ActionsTD;
use Manzadey\LaravelOrchidHelpers\Orchid\Helpers\TD\CreatedAtTD;
use Manzadey\LaravelOrchidHelpers\Orchid\Helpers\TD\IdTD;
use Manzadey\LaravelOrchidHelpers\Orchid\Helpers\TD\UpdateAtTD;
use App\Orchid\Layouts\User\UserFiltersLayout;
use Illuminate\Database\Eloquent\Builder;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\TD;

abstract class AbstractUserListScreen extends AbstractScreen
{
    /**
     * Views.
     *
     * @return string[]|\Orchid\Screen\Layout[]
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function layout() : array
    {
        $this->authorizeList(User::class);

        return [
            ModelsTableLayout::make([
                IdTD::make(),
                TD::make('email')
                    ->width('300px')
                    ->sort()
                    ->filter(),
                TD::make('roles', __('Роли'))
                    ->render(static fn(User $user) : string => $user->roles->implode('name', ', ')),
                UpdateAtTD::make(),
                CreatedAtTD::make(),
                ActionsTD::make(static fn(User $user) : DropDown => DropdownOptions::make()->list([
                    ShowLink::make()
                        ->route('platform.users.show', $user)
                        ->can('show', $user),
                    EditLink::make()
                        ->route('platform.users.edit', $user)
                        ->can('edit', $user),
                ])),
            ]),
        ];
    }

    protected function getBuilder(User|Builder $builder = null) : Builder
    {
        return ($builder ?? User::query())
            ->with('roles')
            ->filters()
            ->filtersApplySelection(UserFiltersLayout::class)
            ->defaultSort('id', 'desc');
    }
}
