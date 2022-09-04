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
use App\Orchid\Layouts\HttpLogChart;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Layouts\Selection;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;
use stdClass;

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

            'charts' => [
                $this->generateChartData(),
            ],
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

            HttpLogChart::class,

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

    /**
     * @return array[]
     */
    public function generateChartData() : array
    {
        $results = DB::table('http_logs')
            ->selectRaw('COUNT(*) as count, DATE_FORMAT(created_at, "%d.%m.%Y") as date')
            ->groupBy('date')
            ->get();

        $values = $labels = [];
        array_map(static function(Carbon $carbon) use ($results, &$labels, &$values) : void {
            $date  = $carbon->format('d.m.Y');
            $value = 0;

            $labels[] = $date;
            $key      = $results->search(static fn(stdClass $value) => $value->date === $date);

            if($key !== false) {
                $value = $results->get($key)->count;
            }

            $values[] = $value;
        }, CarbonPeriod::create(now()->subDays(14), now())->toArray());

        return compact('labels', 'values');
    }
}
