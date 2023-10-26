<?php

declare(strict_types = 1);

namespace DigitalCreative\ChartJsWidget\Formatters;

/**
 * Class NoTitleFormatter
 */
class NoTitleFormatter extends Formatter
{
    public function type(): string
    {
        return 'no-title-formatter';
    }
}
