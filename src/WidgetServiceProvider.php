<?php

declare(strict_types = 1);

namespace DigitalCreative\ChartJsWidget;

use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Nova;

class WidgetServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Nova::serving(function (ServingNova $event): void {

            Nova::script('chartjs-widget', __DIR__ . '/../dist/js/widget.js');
            Nova::style('chartjs-widget', __DIR__ . '/../dist/css/widget.css');

        });
    }
}
