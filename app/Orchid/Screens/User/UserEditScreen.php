<?php

declare(strict_types=1);

namespace App\Orchid\Screens\User;

use App\Models\User;
use App\Orchid\Helpers\Screen\EditScreen;
use App\Orchid\Layouts\Role\RolePermissionLayout;
use App\Orchid\Layouts\User\UserEditLayout;
use App\Orchid\Layouts\User\UserPasswordLayout;
use App\Orchid\Layouts\User\UserRoleLayout;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use JetBrains\PhpStorm\ArrayShape;
use Orchid\Access\UserSwitch;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

/**
 * @property User $model
 */
class UserEditScreen extends EditScreen
{
    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    #[ArrayShape([0 => 'iterable', 'permission' => "\Illuminate\Support\Collection"])]
    public function query(User $user) : array
    {
        $this->authorizeEdit($user);

        $user->load(['roles']);

        return [
            ...$this->model($user),
            'permission' => $user->getStatusPermission(),
        ];
    }

    /**
     * @return \Orchid\Screen\Layout[]
     */
    public function layout() : array
    {
        return [
            Layout::block(UserEditLayout::class)
                ->title(__('Profile Information'))
                ->description(__('Update your account\'s profile information and email address.'))
                ->commands(
                    Button::make(__('Save'))
                        ->type(Color::DEFAULT())
                        ->icon('check')
                        ->canSee($this->model->exists)
                        ->method('save')
                ),

            Layout::block(UserPasswordLayout::class)
                ->title(__('Password'))
                ->description(__('Ensure your account is using a long, random password to stay secure.'))
                ->commands(
                    Button::make(__('Save'))
                        ->type(Color::DEFAULT())
                        ->icon('check')
                        ->canSee($this->model->exists)
                        ->method('save')
                ),

            Layout::block(UserRoleLayout::class)
                ->title(__('Roles'))
                ->description(__('A Role defines a set of tasks a user assigned the role is allowed to perform.'))
                ->commands(
                    Button::make(__('Save'))
                        ->type(Color::DEFAULT())
                        ->icon('check')
                        ->canSee($this->model->exists)
                        ->method('save')
                ),

            Layout::block(RolePermissionLayout::class)
                ->title(__('Permissions'))
                ->description(__('Allow the user to perform some actions that are not provided for by his roles'))
                ->commands(
                    Button::make(__('Save'))
                        ->type(Color::DEFAULT())
                        ->icon('check')
                        ->canSee($this->model->exists)
                        ->method('save')
                ),
        ];
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function save(User $user, Request $request) : RedirectResponse
    {
        $this->authorize('edit', $user);

        $request->validate([
            'model.email' => [
                'required',
                Rule::unique(User::class, 'email')->ignore($user),
            ],
        ]);

        $permissions = collect($request->get('permissions'))
            ->map(fn($value, $key) => [base64_decode($key) => $value])
            ->collapse()
            ->toArray();

        $userData = $request->get('model');
        if($user->exists && (string) $userData['password'] === '') {
            // When updating existing user null password means "do not change current password"
            unset($userData['password']);
        } else {
            $userData['password'] = Hash::make($userData['password']);
        }

        $user
            ->fill($userData)
            ->fill([
                'permissions' => $permissions,
            ])
            ->save();

        $user->replaceRoles($request->input('model.roles'));

        Toast::info(__('User was saved.'));

        return to_route('platform.users.show', $user);
    }

    public function loginAs(User $user) : RedirectResponse
    {
        UserSwitch::loginAs($user);

        Toast::info(__('You are now impersonating this user'));

        return to_route(config('platform.index'));
    }
}
