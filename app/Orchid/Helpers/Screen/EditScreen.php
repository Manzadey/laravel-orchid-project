<?php

declare(strict_types=1);

namespace App\Orchid\Helpers\Screen;

use App\Orchid\Helpers\Button\SaveButton;
use Illuminate\Database\Eloquent\Model;

abstract class EditScreen extends ModelScreen
{
    public function commandBar() : iterable
    {
        return [
            SaveButton::make(),
        ];
    }

    protected function field(string $field) : string
    {
        return "model.$field";
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    protected function authorizeEdit(Model $model) : void
    {
        $this->authorize($model->exists ? 'edit' : 'create', $model);
    }
}
