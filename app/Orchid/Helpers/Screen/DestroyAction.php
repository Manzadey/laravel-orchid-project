<?php

declare(strict_types=1);

namespace App\Orchid\Helpers\Screen;

use App\Orchid\Helpers\Alerts\DestroyAlert;
use Arr;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Route;

/**
 * @mixin \Orchid\Screen\Screen
 */
trait DestroyAction
{
    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Throwable
     */
    public function destroy(Request $request) : ?RedirectResponse
    {

        abort_if($request->isNotFilled(['morph', 'id']), 403);

        $model = $request->input('morph');

        abort_unless(class_exists($model), 403);

        $model = app($model);
        abort_unless($model instanceof Model, 403);

        /* @var Model $model */
        $model = $model->query()->findOrFail($request->input('id'));

        $this->authorize('delete', $model);
        $model->delete();

        DestroyAlert::make();

        if($request->filled('redirect')) {
            return redirect($request->input('redirect'));
        }

        $parameters = Arr::except(Route::current()->parameters, 'method');

        return to_route(str_replace('show', 'list', Route::currentRouteName()), $parameters);
    }
}
