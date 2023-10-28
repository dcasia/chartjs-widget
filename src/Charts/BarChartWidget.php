<?php

declare(strict_types = 1);

namespace DigitalCreative\ChartJsWidget\Charts;

use DigitalCreative\ChartJsWidget\ChartJsWidget;

abstract class BarChartWidget extends ChartJsWidget
{
    public string $type = 'bar';
}
