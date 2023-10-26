<?php

declare(strict_types = 1);

namespace DigitalCreative\ChartJsWidget\Formatters;

/**
 * Class SimpleTitleFormatter
 *
 * @method self format(string $value)
 */
class SimpleTitleFormatter extends Formatter
{
    public function __construct(string $format)
    {
        parent::__construct();

        $this->format($format);
    }

    public function type(): string
    {
        return 'simple-title-formatter';
    }
}
