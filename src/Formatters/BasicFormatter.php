<?php

namespace DigitalCreative\ChartJsWidget\Formatters;

/**
 * Class BasicFormatter
 *
 * @method self prefix(string $value)
 * @method self suffix(string $value)
 * @method self useComma(bool $value)
 * @method self hideLabel(bool $value)
 *
 * @package DigitalCreative\ChartJsWidget\Formatters
 */
class BasicFormatter extends Formatter
{
    public function type(): string
    {
        return 'basic-formatter';
    }
}
