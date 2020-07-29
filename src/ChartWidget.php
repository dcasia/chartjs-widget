<?php

namespace DigitalCreative\ChartWidget;

use DigitalCreative\NovaDashboard\Widget;

abstract class ChartWidget extends Widget
{
    public function component(): string
    {
        return 'chart-widget';
    }
}
