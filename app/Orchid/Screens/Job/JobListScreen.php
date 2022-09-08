<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Job;

use App\Models\Job;
use Illuminate\Support\Collection;
use JetBrains\PhpStorm\ArrayShape;
use Manzadey\LaravelOrchidHelpers\Orchid\Helpers\Layouts\ModelsTableLayout;
use Manzadey\LaravelOrchidHelpers\Orchid\Helpers\Links\DropdownOptions;
use Manzadey\LaravelOrchidHelpers\Orchid\Helpers\Links\ShowLink;
use Manzadey\LaravelOrchidHelpers\Orchid\Helpers\Screens\AbstractScreen;
use Manzadey\LaravelOrchidHelpers\Orchid\Helpers\TD\ActionsTD;
use Manzadey\LaravelOrchidHelpers\Orchid\Helpers\TD\CreatedAtTD;
use Manzadey\LaravelOrchidHelpers\Orchid\Helpers\TD\IdTD;
use Manzadey\LaravelOrchidHelpers\Orchid\Helpers\TD\TimestampTD;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;

class JobListScreen extends AbstractScreen
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
                    ShowLink::route('platform.jobs.show', $job),
                ])),
            ]),
        ];
    }
}
