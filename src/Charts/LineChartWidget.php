<?php

declare(strict_types = 1);

namespace DigitalCreative\ChartJsWidget\Charts;

use DigitalCreative\ChartJsWidget\ChartJsWidget;

abstract class LineChartWidget extends ChartJsWidget
{
    public string $type = 'line';
}
