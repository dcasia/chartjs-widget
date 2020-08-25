<?php

namespace DigitalCreative\ChartJsWidget;

use DigitalCreative\NovaDashboard\Widget;

abstract class PieChartWidget extends Widget
{
    public function component(): string
    {
        return 'pie-chart-widget';
    }
}
