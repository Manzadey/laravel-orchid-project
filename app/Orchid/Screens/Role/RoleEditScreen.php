<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Role;

use App\Models\Role;
use App\Orchid\Layouts\Role\RoleEditLayout;
use App\Orchid\Layouts\Role\RolePermissionLayout;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Manzadey\LaravelOrchidHelpers\Orchid\Helpers\Alerts\SaveAlert;
use Manzadey\LaravelOrchidHelpers\Orchid\Helpers\Screens\EditScreen;
use Orchid\Support\Facades\Layout;

class RoleEditScreen extends EditScreen
{
    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function query(Role $role) : iterable
    {
        $this->authorizeEdit($role);

        return array_merge((array) $this->model($role), [
            'permission' => $role->getStatusPermission(),
        ]);
    }

    public function layout() : array
    {
        return [
            Layout::block([
                RoleEditLayout::class,
            ])
                ->title('Role')
                ->description('A role is a collection of privileges
                (of possibly different services like the Users service, Moderator, and so on)
                 that grants users with that role the ability to perform certain tasks or operations.'),

            Layout::block([
                RolePermissionLayout::class,
            ])
                ->title('Permission/Privilege')
                ->description('A privilege is necessary to perform certain tasks and operations in an area.'),
        ];
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function save(Role $role, Request $request) : RedirectResponse
    {
        $this->authorizeEdit($role);

        $request->validate([
            'model.slug' => [
                'required',
                Rule::unique(Role::class, 'slug')->ignore($role),
            ],
        ]);

        $role->fill($request->get('model'));

        $role->permissions = collect($request->get('permissions'))
            ->map(fn($value, $key) => [base64_decode($key) => $value])
            ->collapse()
            ->toArray();

        $role->save();

        SaveAlert::make();

        return to_route('platform.roles.show', $role);
    }
}
