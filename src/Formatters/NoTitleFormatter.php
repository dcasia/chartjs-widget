<?php

namespace DigitalCreative\ChartJsWidget\Formatters;

/**
 * Class NoTitleFormatter
 *
 * @package DigitalCreative\ChartJsWidget\Formatters
 */
class NoTitleFormatter extends Formatter
{
    public function type(): string
    {
        return 'no-title-formatter';
    }
}
