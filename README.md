# ChartJS Widget for Nova Dashboard

[![Latest Version on Packagist](https://img.shields.io/packagist/v/digital-creative/chartjs-widget)](https://packagist.org/packages/digital-creative/chartjs-widget)
[![Total Downloads](https://img.shields.io/packagist/dt/digital-creative/chartjs-widget)](https://packagist.org/packages/digital-creative/chartjs-widget)
[![License](https://img.shields.io/packagist/l/digital-creative/chartjs-widget)](https://github.com/dcasia/chartjs-widget/blob/main/LICENSE)

<picture>
  <source media="(prefers-color-scheme: dark)" srcset="https://raw.githubusercontent.com/dcasia/chartjs-widget/main/screenshots/dark.png">
  <img alt="Nova ChartJs Widget" src="https://raw.githubusercontent.com/dcasia/chartjs-widget/main/screenshots/light.png">
</picture>

A ChartJs widget for laravel [Nova Dashboard](https://github.com/dcasia/nova-dashboard).

# Installation

You can install the package via composer:

```
composer require digital-creative/chartjs-widget
```

## Basic Usage

Most of the configuration options can be inferred directly from the official [Chart.js documentation](https://www.chartjs.org/docs/latest/configuration/#configuration).

```php
use DigitalCreative\ChartJsWidget\Charts\BarChartWidget;
use DigitalCreative\NovaDashboard\Filters;
use Illuminate\Support\Collection;
use Laravel\Nova\Http\Requests\NovaRequest;

class Example extends BarChartWidget
{
    public function configure(NovaRequest $request): void
    {
        /**
         * These set the title and the button on the top-right if there are multiple "tabs" on this view
         */
        $this->title('Example BarChart');
        $this->buttonTitle('BarChart');
        $this->backgroundColor(dark: '#1e293b', light: '#ffffff');

        $this->padding(top: 30, bottom: 5);

        $this->tooltip([]); // https://www.chartjs.org/docs/latest/configuration/tooltip.html#tooltip
        $this->scales([]);  // https://www.chartjs.org/docs/latest/axes/#axes
        $this->legend([]);  // https://www.chartjs.org/docs/latest/configuration/legend.html#legend
        $this->elements();  // https://www.chartjs.org/docs/latest/configuration/elements.html#elements

        /**
         * These will create another tab on the same view, it doesn't necessarily need to be
         * another chart of the same type it can be any other chart.
         */
        $this->addTab(Chart2::class);
        $this->addTab(Chart3::class);
    }

    public function value(Filters $filters): array
    {
        return [
            'labels' => Collection::range(0, 5)->map(fn () => fake()->word()),
            'datasets' => Collection::range(0, 5)->map(fn () => [
                'data' => Collection::range(0, 5)->map(fn () => fake()->numberBetween(0, 100)),
            ]),
        ];
    }
}
```

All chart types are available:

- [BarChartWidget](https://www.chartjs.org/docs/latest/charts/bar.html)
- [BubbleChartWidget](https://www.chartjs.org/docs/latest/charts/bubble.html)
- [DoughnutChartWidget](https://www.chartjs.org/docs/latest/charts/doughnut.html)
- [LineChartWidget](https://www.chartjs.org/docs/latest/charts/line.html)
- [PieChartWidget](https://www.chartjs.org/docs/latest/charts/doughnut.html#pie)
- [PolarAreaChartWidget](https://www.chartjs.org/docs/latest/charts/polar.html)
- [RadarChartWidget](https://www.chartjs.org/docs/latest/charts/radar.html)
- [ScatterChartWidget](https://www.chartjs.org/docs/latest/charts/scatter.html)

## ⭐️ Show Your Support

Please give a ⭐️ if this project helped you!

### Other Packages You Might Like

- [Nova Dashboard](https://github.com/dcasia/nova-dashboard) - The missing dashboard for Laravel Nova!
- [Nova Welcome Card](https://github.com/dcasia/nova-welcome-card) - A configurable version of the `Help card` that comes with Nova.
- [Icon Action Toolbar](https://github.com/dcasia/icon-action-toolbar) - Replaces the default boring action menu with an inline row of icon-based actions.
- [Expandable Table Row](https://github.com/dcasia/expandable-table-row) - Provides an easy way to append extra data to each row of your resource tables.
- [Collapsible Resource Manager](https://github.com/dcasia/collapsible-resource-manager) - Provides an easy way to order and group your resources on the sidebar.
- [Resource Navigation Tab](https://github.com/dcasia/resource-navigation-tab) - Organize your resource fields into tabs.
- [Resource Navigation Link](https://github.com/dcasia/resource-navigation-link) - Create links to internal or external resources.
- [Nova Mega Filter](https://github.com/dcasia/nova-mega-filter) - Display all your filters in a card instead of a tiny dropdown!
- [Nova Pill Filter](https://github.com/dcasia/nova-pill-filter) - A Laravel Nova filter that renders into clickable pills.
- [Nova Slider Filter](https://github.com/dcasia/nova-slider-filter) - A Laravel Nova filter for picking range between a min/max value.
- [Nova Range Input Filter](https://github.com/dcasia/nova-range-input-filter) - A Laravel Nova range input filter.
- [Nova FilePond](https://github.com/dcasia/nova-filepond) - A Nova field for uploading File, Image and Video using Filepond.
- [Custom Relationship Field](https://github.com/dcasia/custom-relationship-field) - Emulate HasMany relationship without having a real relationship set between resources.
- [Column Toggler](https://github.com/dcasia/column-toggler) - A Laravel Nova package that allows you to hide/show columns in the index view.
- [Batch Edit Toolbar](https://github.com/dcasia/batch-edit-toolbar) - Allows you to update a single column of a resource all at once directly from the index page.

## License

The MIT License (MIT). Please see [License File](https://raw.githubusercontent.com/dcasia/chartjs-widget/main/LICENSE) for more information.
