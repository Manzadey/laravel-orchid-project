<?php

declare(strict_types=1);

namespace App\Orchid\Screens\HttpLog;

use App\Models\HttpLog;
use App\Orchid\Helpers\Layouts\ModelLegendLayout;
use App\Orchid\Helpers\Layouts\ModelTimestampsLayout;
use App\Orchid\Helpers\Screen\ModelScreen;
use App\Orchid\Helpers\Sight\EntitySight;
use App\Orchid\Helpers\Sight\IdSight;
use App\Orchid\Helpers\Sight\PrintSight;
use App\Orchid\Helpers\Sight\Sight;
use App\Orchid\Helpers\Sight\TimestampSight;

class HttpLogShowScreen extends ModelScreen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(HttpLog $httpLog): iterable
    {
        return $this->model($httpLog);
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            ModelLegendLayout::make([
                IdSight::make(),
                EntitySight::make('user', __('Пользователь')),
                Sight::make('ip', __('IP')),
                Sight::make('name', __('Маршрут')),
                Sight::make('method', __('Метод')),
                Sight::make('scheme', __('Схема')),
                Sight::make('host', __('Хост')),
                Sight::make('port', __('Порт')),
                Sight::make('path'),
                PrintSight::make('query'),
                PrintSight::make('payload'),
                PrintSight::make('headers'),
            ]),

            ModelTimestampsLayout::make(),
        ];
    }
}
