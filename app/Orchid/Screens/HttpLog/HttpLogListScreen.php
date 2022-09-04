<?php

declare(strict_types=1);

namespace App\Orchid\Screens\HttpLog;

use App\Models\HttpLog;
use App\Orchid\Filters\CreatedTimestampFilter;
use App\Orchid\Filters\UserFilter;
use App\Orchid\Helpers\Layouts\ModelsTableLayout;
use App\Orchid\Helpers\Link\DropdownOptions;
use App\Orchid\Helpers\Link\ShowLink;
use App\Orchid\Helpers\Screen\AbstractListScreen;
use App\Orchid\Helpers\TD\ActionsTD;
use App\Orchid\Helpers\TD\CreatedAtTD;
use App\Orchid\Helpers\TD\EntityRelationTD;
use App\Orchid\Helpers\TD\IdTD;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Layouts\Selection;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;

class HttpLogListScreen extends AbstractListScreen
{
    /**
     * Query data.
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @return array
     */
    public function query() : iterable
    {
        $this->authorizeList(HttpLog::class);

        return [
            'models' => HttpLog::filters()
                ->filtersApplySelection($this->selection())
                ->latest('id')
                ->with('user')
                ->paginate(),
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout() : iterable
    {
        return [
            $this->selection(),

            ModelsTableLayout::make([
                IdTD::make(),
                EntityRelationTD::make('user', __('Пользователь')),
                TD::make('method', __('Метод'))
                    ->filter(TD::FILTER_SELECT)
                    ->filterOptions([
                        'GET'  => 'GET',
                        'POST' => 'POST',
                    ]),
                TD::make('path', __('Путь')),
                TD::make('ip'),
                CreatedAtTD::make(),
                ActionsTD::make(static fn(HttpLog $httpLog) : DropDown => DropdownOptions::make()->list([
                    ShowLink::makeFromModel($httpLog, 'platform.http-logs.show'),
                ])),
            ]),
        ];
    }

    private function selection() : Selection
    {
        return Layout::selection([
            UserFilter::class,
            CreatedTimestampFilter::class,
        ]);
    }
}
