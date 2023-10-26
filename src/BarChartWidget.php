<?php

declare(strict_types = 1);

namespace DigitalCreative\ChartJsWidget;

abstract class BarChartWidget extends LineChartWidget
{
    public function component(): string
    {
        return 'bar-chart-widget';
    }
}
