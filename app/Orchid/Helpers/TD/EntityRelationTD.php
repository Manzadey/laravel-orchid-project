<?php

declare(strict_types=1);

namespace App\Orchid\Helpers\TD;

use App\Orchid\Layouts\Persona;
use Orchid\Screen\TD;

class EntityRelationTD
{
    public static function make(string $relation, string $title) : TD
    {
        return TD::make($relation, $title)
            ->width('300px')
            ->render(static fn($model) : ?Persona => data_get($model, $relation) ? new Persona(data_get($model, $relation)?->presenter()) : null);
    }
}
