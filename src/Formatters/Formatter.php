<?php

namespace DigitalCreative\ChartJsWidget\Formatters;

use Illuminate\Support\Fluent;
use Laravel\Nova\Makeable;

abstract class Formatter extends Fluent
{
    use Makeable;

    abstract public function type(): string;

    public function jsonSerialize(): array
    {
        return [
            'type' => $this->type(),
            'options' => parent::jsonSerialize(),
        ];
    }
}
