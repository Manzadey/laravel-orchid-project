<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Job;

use App\Models\Job;
use App\Orchid\Helpers\Layouts\ModelsTableLayout;
use App\Orchid\Helpers\Link\DropdownOptions;
use App\Orchid\Helpers\Link\ShowLink;
use App\Orchid\Helpers\Screen\AbstractListScreen;
use App\Orchid\Helpers\TD\ActionsTD;
use App\Orchid\Helpers\TD\CreatedAtTD;
use App\Orchid\Helpers\TD\IdTD;
use App\Orchid\Helpers\TD\TimestampTD;
use Illuminate\Support\Collection;
use JetBrains\PhpStorm\ArrayShape;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;

class JobListScreen extends AbstractListScreen
{
    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    #[ArrayShape(['models' => Collection::class, 'count' => "int"])]
    public function query() : array
    {
        $this->authorizeList(Job::class);

        $models = Job::latest('id')->get();

        return [
            'models' => $models,
            'count'  => $models->count(),
        ];
    }

    public function layout() : array
    {
        return [
            Layout::metrics([
                __('Обрабатывается') => 'count',
            ]),

            ModelsTableLayout::make([
                IdTD::make(),
                TD::make('display_name', 'Название'),
                TD::make('attempts', 'Попытки'),
                TimestampTD::make('reserved_at', attrName('Зарезервировано')),
                TimestampTD::make('available_at', attrName('Доступно')),
                CreatedAtTD::make(),
                ActionsTD::make(static fn(Job $job) : DropDown => DropdownOptions::make()->list([
                    ShowLink::makeFromModel($job, 'platform.jobs.show'),
                ])),
            ]),
        ];
    }
}
