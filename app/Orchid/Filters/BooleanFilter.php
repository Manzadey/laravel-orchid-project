<?php

declare(strict_types=1);

namespace App\Orchid\Filters;

use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\RadioButtons;

class BooleanFilter extends Filter
{
    public function __construct(
        readonly private string $field,
        readonly private string $false = 'Нет',
        readonly private string $true = 'Да',
    )
    {
        parent::__construct();
    }

    /**
     * The displayable name of the filter.
     *
     * @return string
     */
    public function name() : string
    {
        return __("validation.attributes.model.$this->field");
    }

    /**
     * The array of matched parameters.
     *
     * @return array|null
     */
    public function parameters() : ?array
    {
        return [
            $this->field,
        ];
    }

    /**
     * Apply to a given Eloquent query builder.
     *
     * @param  Builder  $builder
     *
     * @return Builder
     */
    public function run(Builder $builder) : Builder
    {
        return $builder->where($this->field, (bool) $this->request->input($this->field));
    }

    /**
     * Get the display fields.
     *
     * @return Field[]
     */
    public function display() : iterable
    {
        return [
            RadioButtons::make($this->field)
                ->options([
                    null => 'Все',
                    0    => $this->false,
                    1    => $this->true,
                ])
                ->value($this->request->input($this->field))
                ->title(__("validation.attributes.model.$this->field")),
        ];
    }
}
