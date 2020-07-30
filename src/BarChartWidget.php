<?php

namespace DigitalCreative\ChartWidget;

abstract class BarChartWidget extends LineChartWidget
{
    public function component(): string
    {
        return 'bar-chart-widget';
    }
}
