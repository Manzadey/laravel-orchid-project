<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Job;

use App\Models\Job;
use App\Orchid\Helpers\Layouts\ModelLegendLayout;
use App\Orchid\Helpers\Screen\ModelScreen;
use App\Orchid\Helpers\Sight\CreatedAtSight;
use App\Orchid\Helpers\Sight\IdSight;
use App\Orchid\Helpers\Sight\PrintSight;
use App\Orchid\Helpers\Sight\Sight;
use App\Orchid\Helpers\Sight\TimestampSight;

class JobShowScreen extends ModelScreen
{
    /**
     * Query data.
     *
     * @return array
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function query(Job $job) : iterable
    {
        $this->authorizeShow($job);

        return $this->model($job);
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout() : iterable
    {
        return [
            ModelLegendLayout::make([
                IdSight::make(),
                Sight::make('attempts', __('Попыток')),
                Sight::make('queue', __('Очередь')),
            ]),

            ModelLegendLayout::make([
                PrintSight::make('payload', __('Данные очереди')),
            ]),

            ModelLegendLayout::make([
                TimestampSight::make('reserved_at', attrName('Зарезервировано')),
                TimestampSight::make('available_at', attrName('Доступно')),
                CreatedAtSight::make(),
            ]),
        ];
    }
}
