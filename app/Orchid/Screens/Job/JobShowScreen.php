<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Job;

use App\Models\Job;
use Manzadey\LaravelOrchidHelpers\Orchid\Helpers\Layouts\ModelLegendLayout;
use Manzadey\LaravelOrchidHelpers\Orchid\Helpers\Screens\ModelScreen;
use Manzadey\LaravelOrchidHelpers\Orchid\Helpers\Sights\CreatedAtSight;
use Manzadey\LaravelOrchidHelpers\Orchid\Helpers\Sights\IdSight;
use Manzadey\LaravelOrchidHelpers\Orchid\Helpers\Sights\PrintSight;
use Manzadey\LaravelOrchidHelpers\Orchid\Helpers\Sights\Sight;
use Manzadey\LaravelOrchidHelpers\Orchid\Helpers\Sights\TimestampSight;

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
