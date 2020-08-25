# ChartJS Widget for Nova Dashboard

[![Latest Version on Packagist](https://img.shields.io/packagist/v/digital-creative/chartjs-widget)](https://packagist.org/packages/digital-creative/chartjs-widget)
[![Total Downloads](https://img.shields.io/packagist/dt/digital-creative/chartjs-widget)](https://packagist.org/packages/digital-creative/chartjs-widget)
[![License](https://img.shields.io/packagist/l/digital-creative/chartjs-widget)](https://github.com/dcasia/chartjs-widget/blob/master/LICENSE)


# Documentation 

WIP

Basic sample meanwhile docs is not ready:

```php
<?php

declare(strict_types = 1);

namespace App\Nova\Dashboards\Widgets;

use DigitalCreative\ChartJsWidget\Color;
use DigitalCreative\ChartJsWidget\DataSet;
use DigitalCreative\ChartJsWidget\Gradient;
use DigitalCreative\ChartJsWidget\LineChartWidget;
use DigitalCreative\ChartJsWidget\Style;
use DigitalCreative\ChartJsWidget\ValueResult;
use DigitalCreative\NovaDashboard\Filters;
use Illuminate\Support\Collection;
use Laravel\Nova\Fields\Select;

class SampleLineChart extends LineChartWidget
{

    public const SOURCE = 'source';
    public const SOURCE_SAMPLE1 = 'sample1';
    public const SOURCE_SAMPLE2 = 'sample2';

    public function getRandomData($min = 1, $max = 100): array
    {
        return [
            random_int($min, $max),
            random_int($min, $max),
            random_int($min, $max),
            random_int($min, $max),
            random_int($min, $max),
            random_int($min, $max),
            random_int($min, $max),
            random_int($min, $max),
            random_int($min, $max),
        ];
    }

    public function resolveValue(Collection $options, Filters $filters): ValueResult
    {

        /**
         * Some basic stylish settings
         */
        $baseConfiguration = Style::make()
                                    ->fill('origin')
                                    ->pointBorderWidth(2)
                                    ->pointHitRadius(10)
                                    ->pointRadius(4)
                                    ->pointHoverRadius(4)
                                    ->borderWidth(2)
                                    ->pointHoverBorderWidth(4)
                                    ->pointHoverRadius(8);

        if ($options->get(self::SOURCE) === self::SOURCE_SAMPLE1) {

            /**
             * Customize some options based on the dataset
             */
            $set1Configuration = $baseConfiguration->clone()
                                                   ->color('#00c6fb')
                                                   ->pointBorderColor(new Color('white'))
                                                   ->backgroundColor(
                                                       new Gradient([ 'rgba(0, 198, 251, .8)', 'rgba(255,255,255,0)' ], Gradient::VERTICAL)
                                                   );

            $set2Configuration = $baseConfiguration->clone()
                                                   ->color('#005bea')
                                                   ->fill('origin')
                                                   ->pointBorderColor('white')
                                                   ->backgroundColor([ 'rgba(0, 91, 234,.8)', 'rgba(255,255,255,0)', Gradient::VERTICAL ]);

            $dataset1 = DataSet::make('Sample 1', $this->getRandomData(), $set1Configuration);
            $dataset2 = DataSet::make('Sample 2', $this->getRandomData(), $set2Configuration);

            return ValueResult::make()
                        ->labels($this->getRandomData())
                        ->addDataset(
                            $dataset1, $dataset2
                        );

        }

        return ValueResult::make()
                    ->labels($this->getRandomData())
                    ->addDataset(
                        DataSet::make('Hello', $this->getRandomData(), $baseConfiguration->color([ '#FAD961', '#F76B1C' ])
                                                                            ->pointBorderColor('white')
                    ));

    }

    public function fields(): array
    {
        return array_merge([

            Select::make('Data Source', self::SOURCE)
                  ->options([
                      self::SOURCE_SAMPLE1 => 'Data source 1',
                      self::SOURCE_SAMPLE2 => 'Data source 2',
                  ]),

            /**
             * You could let the user choose the color style by creating something like this:
             */
            Select::make('Color Preset', 'colorsPreset')
                  ->options([
                      'orange' => 'Orange',
                      'red' => 'Red',
                  ]),

        ], parent::fields());

    }
}

```


For Pie Chart, quite the same: 

```php
<?php

declare(strict_types=1);

namespace App\Nova\Dashboards\Widgets;

use DigitalCreative\ChartJsWidget\DataSet;
use DigitalCreative\ChartJsWidget\PieChartWidget;
use DigitalCreative\ChartJsWidget\Style;
use DigitalCreative\ChartJsWidget\ValueResult;
use DigitalCreative\NovaDashboard\Filters;
use Illuminate\Support\Collection;

class SolarInPercentChart extends PieChartWidget
{

    public static $title = "Pourcentages";

    public function resolveValue(Collection $options, Filters $filters): ValueResult
    {

        $baseConfiguration = Style::make()
            ->fill('origin')
            ->pointBorderWidth(2)
            ->borderWidth(5)
            ->pointHoverBorderWidth(4)
            ->pointHoverRadius(8);

        $config1 = $baseConfiguration->clone()
            ->borderWidth(0)
            ->hoverBackgroundColor('rgba(255, 159, 64, 0.9)')
            ->backgroundColor('rgba(255, 159, 64, 1)');
        $config2 = $baseConfiguration->clone()
            ->borderWidth(0)
            ->backgroundColor('rgba(54, 162, 235, 1)');

        // Here is my problem, if I make only 1 serie, it will work, but everybody has same config / label
        // If I put several datasets, instead of having quarters, I have circles.
        // I think DataSet structure won't be able to manage those 2 types of charts.         
        $dataset = DataSet::make("mylabel", [1,2,3], $baseConfiguration);

        $result = ValueResult::make()
            ->labels(['a','b','c']);

        $result->addDataset(
            $dataset
        );

        return $result;
    }

    public function fields(): array
    {
        return array_merge([
        ], parent::fields());

    }
}


```