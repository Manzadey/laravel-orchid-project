<?php

declare(strict_types=1);

namespace App\Orchid\Screens;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Manzadey\LaravelOrchidHelpers\Orchid\Helpers\Screens\AbstractScreen;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Storage;

class StorageLogScreen extends AbstractScreen
{
    private array $logs = [];

    /**
     * Query data.
     *
     * @return array
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function query(Request $request) : iterable
    {
        $this->authorize('storage-logs-list');

        $this->logs = collect(Storage::disk('logs')->allFiles())
            ->filter(static fn(string $log) => str_contains($log, '.log'))
            ->values()
            ->toArray();

        $data = '';
        if($request->filled('log') && isset($this->logs[$request->input('log')])) {
            $file = $this->logs[$request->input('log')];

            $data = Storage::disk('logs')->get($file);
        }

        return compact('data');
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout() : iterable
    {
        return [
            Layout::rows([
                Group::make([
                    Select::make('log')
                        ->title(__('Выберите лог'))
                        ->options($this->logs)
                        ->empty()
                        ->value((int) request('log'))
                        ->required(),
                    Button::make(__('Показать содержимое'))
                        ->type(Color::DEFAULT())
                        ->method('getLog'),
                ])->alignEnd(),
            ]),

            Layout::rows([
                TextArea::make('data')
                    ->rows(50)
                    ->class('form-control no-resize')
                    ->style('max-width:100%'),
            ])->canSee(request()?->has('log')),
        ];
    }

    public function getLog(Request $request) : RedirectResponse
    {
        return to_route('platform.storage-logs', [
            'log' => $request->input('log'),
        ]);
    }
}
