<?php

namespace DigitalCreative\ChartJsWidget;

abstract class BarChartWidget extends LineChartWidget
{
    public function component(): string
    {
        return 'bar-chart-widget';
    }
}
