<?php

declare(strict_types = 1);

namespace DigitalCreative\ChartJsWidget\Charts;

use DigitalCreative\ChartJsWidget\ChartJsWidget;

abstract class PieChartWidget extends ChartJsWidget
{
    public string $type = 'pie';
}
