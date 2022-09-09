<?php

declare(strict_types=1);

namespace App\Orchid;

use App\Orchid\Services\PlatformPermissionService;
use Illuminate\Support\Collection;
use Manzadey\LaravelOrchidStorageLog\Orchid\Actions\Menu\StorageLogsMenu;
use Manzadey\OrchidActivityLog\Orchid\Actions\Menu\ActivityMenu;
use Manzadey\OrchidHttpLog\Orchid\Actions\Menu\HttpLogMenu;
use Orchid\Attachment\Models\Attachment as BaseModel;
use Orchid\Platform\Dashboard;
use Orchid\Platform\ItemPermission;
use Orchid\Platform\OrchidServiceProvider;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\Menu;
use Orchid\Screen\Field;
use App\Models;
use Orchid\Platform as OrchidPlatform;

class PlatformProvider extends OrchidServiceProvider
{
    /**
     * @param Dashboard $dashboard
     */
    public function boot(Dashboard $dashboard): void
    {
        parent::boot($dashboard);

        $dashboard::configure([
            'models' => [
                OrchidPlatform\Models\Role::class => Models\Role::class,
                OrchidPlatform\Models\User::class => Models\User::class,
                BaseModel::class                  => Models\Attachment::class,
            ],
        ]);

        $dashboard->registerResource('stylesheets', vite_entry('resources/platform/css/platform.main.css'));
        $dashboard->registerResource('scripts', vite_entry('resources/platform/js/app.js'));

        $this->registerMacros();
    }

    /**
     * @return Menu[]
     */
    public function registerMainMenu(): array
    {
        return [
            ...$this->groupedMenuItems([
                Menu::make(__('model.users'))
                    ->icon('user')
                    ->route('platform.users.list')
                    ->can('list', Models\User::class),

                Menu::make(__('model.roles'))
                    ->icon('lock')
                    ->route('platform.roles.list')
                    ->can('list', Models\Role::class),
            ], __('Доступы')),

            ...$this->groupedMenuItems([
                StorageLogsMenu::make()
                    ->can('storage-logs-list'),

                ActivityMenu::make(),

                HttpLogMenu::make(),

                Menu::make(__('model.jobs'))
                    ->icon('cs.queue')
                    ->route('platform.jobs.list')
                    ->can('list', Models\Job::class),
            ], __('Системные данные')),
        ];
    }

    /**
     * @return Menu[]
     */
    public function registerProfileMenu(): array
    {
        return [
            Menu::make('Profile')
                ->route('platform.profile')
                ->icon('user'),
        ];
    }

    /**
     * @return ItemPermission[]
     */
    public function registerPermissions(): array
    {
        $permissionService = PlatformPermissionService::make();
        $models = [
            Models\User::class,
            Models\Role::class,
            Models\Job::class,
        ];

        $storageLogs = OrchidPlatform\ItemPermission::group(__('System'))
            ->addPermission('storage-logs-list', __('Чтение системных логов'));

        return collect($models)
            ->map(static fn(string $model) => $permissionService->getPlatformProviderPermissions($model))
            ->push($storageLogs)
            ->toArray();
    }

    private function registerMacros() : void
    {
        Link::macro('can', function($ability, $arguments = []) : Action {
            $this->canSee(auth()->user()?->can($ability, $arguments));

            return $this;
        });

        Field::macro('can', function($ability, $arguments = []) : Field {
            $this->canSee(auth()->user()?->can($ability, $arguments));

            return $this;
        });
    }

    private function groupedMenuItems(array $items, string $title = null) : array
    {
        $collect = collect($items)
            ->filter(static fn(Menu $menu) : bool => $menu->isSee());

        return $collect
            ->map(static fn(Menu $menu, int $i) => $i === array_key_last($collect->toArray()) ? $menu->divider() : $menu)
            ->when($title !== null,
                static fn(Collection $collection) : Collection => $collection
                    ->map(static fn(Menu $menu, int $i) : Menu => $i === array_key_first($collect->toArray()) ? $menu->title($title) : $menu)
            )
            ->toArray();
    }
}
