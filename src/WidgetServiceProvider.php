<?php

namespace DigitalCreative\ChartJsWidget;

use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Nova;

class WidgetServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Nova::serving(function (ServingNova $event) {
            Nova::script('chartjs-widget', __DIR__ . '/../dist/js/widget.js');
        });
    }
}
