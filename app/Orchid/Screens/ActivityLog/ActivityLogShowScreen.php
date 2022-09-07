<?php

declare(strict_types=1);

namespace App\Orchid\Screens\ActivityLog;

use App\Models\ActivityLog;
use App\View\Components\Platform\ActivityLog\ActivityLogPropertiesComponent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use JetBrains\PhpStorm\ArrayShape;
use Manzadey\LaravelOrchidHelpers\Orchid\Helpers\Layouts\ModelLegendLayout;
use Manzadey\LaravelOrchidHelpers\Orchid\Helpers\Screens\ModelScreen;
use Manzadey\LaravelOrchidHelpers\Orchid\Helpers\Sights\CreatedAtSight;
use Manzadey\LaravelOrchidHelpers\Orchid\Helpers\Sights\EntitySight;
use Manzadey\LaravelOrchidHelpers\Orchid\Helpers\Sights\IdSight;
use Manzadey\LaravelOrchidHelpers\Orchid\Helpers\TD\CreatedAtTD;
use Manzadey\LaravelOrchidHelpers\Orchid\Helpers\TD\EntityRelationTD;
use Manzadey\LaravelOrchidHelpers\Orchid\Helpers\TD\IdTD;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Sight;
use Orchid\Screen\TD;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;

/**
 * @property ActivityLog $model
 */
class ActivityLogShowScreen extends ModelScreen
{
    private bool $isSeeRelatedLayout = false;

    /**
     * Query data.
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @return array
     */
    #[ArrayShape([0 => 'iterable', 'related' => 'mixed'])]
    public function query(ActivityLog $activityLog) : iterable
    {
        $this->authorizeShow($activityLog);

        $related = $activityLog->newQuery()
            ->with('causer')
            ->where(static fn(Builder $builder) : Builder => $builder
                ->where('subject_type', $activityLog->subject_type)
                ->where('subject_id', $activityLog->subject_id)
            )
            ->when($activityLog->batch_uuid !== null, static fn(Builder $builder) : Builder => $builder
                ->orWhere('batch_uuid', $activityLog->batch_uuid)
            )
            ->latest('id')
            ->get([
                'id', 'causer_id', 'causer_type', 'created_at', 'event',
            ]);

        $this->isSeeRelatedLayout = $related->count() > 1;

        return [
            ...$this->model($activityLog),
            'related' => $related,
        ];
    }

    public function commandBar() : iterable
    {
        return [
            Button::make('Revert')
                ->icon('action-undo')
                ->confirm(__('activities.confirm_revert'))
                ->method('revert', [
                    'id' => $this->model->id,
                ])
                ->can('edit', $this->model->subject),
        ];
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function revert(ActivityLog $activityLog) : RedirectResponse
    {
        $this->authorize('edit', $activityLog);

        $activityLog
            ->subject
            ->fill($activityLog->properties->get('old'))
            ->save();

        if($activityLog->subject->wasChanged()) {
            $activityLog = $activityLog
                ->subject
                ->activities()
                ->where('subject_type', $activityLog->subject_type)
                ->where('subject_id', $activityLog->subject_id)
                ->latest('id')
                ->first();
        }

        return to_route('platform.systems.activity-logs.show', $activityLog);
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout() : iterable
    {
        $id = $this->model->id;

        $layouts = [
            Layout::columns([
                ModelLegendLayout::make([
                    IdSight::make(),
                    Sight::make('log_name', __('Название лога')),
                    Sight::make('description', __('Описание')),
                    Sight::make('event', __('Событие')),
                    Sight::make('batch_uuid', __('UUID')),
                    EntitySight::make('causer', __('Пользователь')),
                    CreatedAtSight::make(),
                ])->title(__('Подробнее')),
            ])->canSee($this->isSeeRelatedLayout),

            ModelLegendLayout::make([
                EntitySight::make('subject', __('Объект')),
                Sight::make('subject_type', __('Тип')),
                Sight::make('subject_id', __('ID')),
            ])->title(__('Объект')),

            ModelLegendLayout::make([
                EntitySight::make('causer', __('Пользователь')),
                Sight::make('causer_type', __('Тип')),
                Sight::make('causer_id', __('ID')),
            ])->title(__('Пользователь')),
        ];

        if($this->model->repository_properties->isNotEmpty()) {
            $columns = [];

            foreach (['attributes', 'old'] as $status) {
                if($this->model->repository_properties->get($status)) {
                    $sights = collect($this->model->properties->get($status))
                        ->keys()
                        ->map(static fn(string $field) : Sight => Sight::make($field, attrName($field))
                            ->component(ActivityLogPropertiesComponent::class, compact('field'))
                        )
                        ->toArray();

                    $columns[] = Layout::legend("model.repository_properties.$status", $sights)
                        ->title(__("activities.$status"));
                }
            }

            $layouts[] = Layout::columns($columns);
        }

        return [
            Layout::tabs([
                __('Основное') => [
                    $layouts,
                ],

                __('Связанные изменения') => [
                    Layout::table('related', [
                        IdTD::make()
                            ->defaultHidden(false)
                            ->render(static fn(ActivityLog $activityLog) : Link => Link::make((string) $activityLog->id)
                                ->route('platform.activity-logs.show', $activityLog)
                                ->when($id === $activityLog->id, static fn(Link $link) : Link => $link->type(Color::SUCCESS()))
                            ),
                        TD::make('event', __('Событие')),
                        EntityRelationTD::make('causer', __('Пользователь')),
                        CreatedAtTD::make()->alignRight(),
                    ])->title(__('Связанные изменения')),
                ],
            ]),
        ];
    }
}
