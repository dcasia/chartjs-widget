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

use DigitalCreative\ChartWidget\Color;
use DigitalCreative\ChartWidget\DataSet;
use DigitalCreative\ChartWidget\Gradient;
use DigitalCreative\ChartWidget\LineChartWidget;
use DigitalCreative\ChartWidget\Options;
use DigitalCreative\ChartWidget\Value;
use DigitalCreative\NovaDashboard\Filters;
use Illuminate\Support\Collection;
use Laravel\Nova\Fields\Select;

class SampleLineChart extends LineChartWidget
{

    public const SOURCE = 'source';
    public const SOURCE_SAMPLE1 = 'sample1';
    public const SOURCE_SAMPLE2 = 'source2';

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

    public function resolveValue(Collection $options, Filters $filters): Value
    {

        /**
         * Some basic stylish settings
         */
        $baseConfiguration = Options::make()
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
                                                       new Gradient([ 'rgba(0, 198, 251, .8)', 'rgba(255,255,255,0)', Gradient::VERTICAL ])
                                                   );

            $set2Configuration = $baseConfiguration->clone()
                                                   ->color('#005bea')
                                                   ->fill('origin')
                                                   ->pointBorderColor('white')
                                                   ->backgroundColor([ 'rgba(0, 91, 234,.8)', 'rgba(255,255,255,0)', Gradient::VERTICAL ]);

            $dataset1 = DataSet::make('Sample 1', $this->getRandomData(), $set1Configuration);
            $dataset2 = DataSet::make('Sample 2', $this->getRandomData(), $set2Configuration);

            return Value::make()
                        ->labels($this->getRandomData())
                        ->add(
                            $dataset1, $dataset2
                        );

        }

        return Value::make()
                    ->labels(getData())
                    ->add(
                        DataSet::make('Hello', getData(), $baseConfiguration->color([ '#FAD961', '#F76B1C' ])
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
