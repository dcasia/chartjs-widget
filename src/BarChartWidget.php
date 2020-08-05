<?php

namespace DigitalCreative\ChartJsWidget;

use DigitalCreative\NovaDashboard\WidgetOptionTab;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\KeyValue;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Timothyasp\Color\Color as ColorField;

abstract class BarChartWidget extends LineChartWidget
{

    public function resolveWidgetOptions()
    {
        return [
            new WidgetOptionTab('Layout', [
                'layout' => [
                    'padding' => static function (string $attribute) {
                        return KeyValue::make(__('Padding'), $attribute)
                                       ->disableDeletingRows()
                                       ->disableEditingKeys()
                                       ->disableAddingRows()
                                       ->default([
                                           'top' => 0,
                                           'left' => 0,
                                           'right' => 0,
                                           'bottom' => 0,
                                       ]);
                    }
                ],
            ]),
            new WidgetOptionTab('Legend', [
                'legend' => [
                    'display' => static function (string $attribute) {
                        return Boolean::make(__('Display'), $attribute)->default(true);
                    },
                    'reverse' => static function (string $attribute) {
                        return Boolean::make(__('Reverse'), $attribute)
                                      ->default(false)
                                      ->help('Legend will show datasets in reverse order.');
                    },
                    'position' => static function (string $attribute) {
                        return Select::make(__('Position'), $attribute)
                                     ->default('right')
                                     ->options([
                                         'top' => __('Top'),
                                         'left' => __('Left'),
                                         'right' => __('Right'),
                                         'bottom' => __('Bottom'),
                                     ]);
                    },
                    'align' => static function (string $attribute) {
                        return Select::make(__('Align'), $attribute)
                                     ->default('start')
                                     ->options([
                                         'start' => __('Start'),
                                         'center' => __('Center'),
                                         'end' => __('End'),
                                     ]);
                    },
                    'labels' => [
                        'boxWidth' => static function (string $attribute) {
                            return Number::make(__('Box Width'), $attribute)->default(40)->help('Width of coloured box.');
                        },
                        'boxHeight' => static function (string $attribute) {
                            return Number::make(__('Box Height'), $attribute)->default(40)->help('Width of coloured box.');
                        },
                        'padding' => static function (string $attribute) {
                            return Number::make(__('Padding'), $attribute)->default(10)->help('Padding between rows of colored boxes.');
                        },
                        'fontColor' => static function (string $attribute) {
                            return ColorField::make(__('Font Color'), $attribute)->sketch();
                        },
                        'fontSize' => static function (string $attribute) {
                            return Number::make(__('Font Size'), $attribute)->default(40)->help('Width of coloured box.');
                        },
                        'usePointStyle' => static function (string $attribute) {
                            return Boolean::make(__('Use Point Style'), $attribute)
                                          ->default(true)
                                          ->help('Label style will match corresponding point style (size is based on the minimum value between boxWidth and fontSize).');
                        },
                    ],
                ],
            ]),
            new WidgetOptionTab('Tooltips', [
                'tooltips' => [
                    'enabled' => static function (string $attribute) {
                        return Boolean::make(__('Enabled'), $attribute)->default(true);
                    },
                    'intersect' => static function (string $attribute) {
                        return Boolean::make(__('Intersect'), $attribute)
                                      ->default(true)
                                      ->help('If true, the tooltip mode applies only when the mouse position intersects with an element. If false, the mode will be applied at all times.');

                    },
                    'mode' => static function (string $attribute) {
                        return Select::make(__('Mode'), $attribute)
                                     ->default('nearest')
                                     ->help('Sets which elements appear in the tooltip.')
                                     ->options([
                                         'nearest' => __('Nearest'),
                                         'point' => __('Point'),
                                         'index' => __('Index'),
                                         'dataset' => __('Dataset'),
                                         'x' => __('X'),
                                         'y' => __('Y'),
                                     ]);
                    },
                    'backgroundColor' => static function (string $attribute) {
                        return ColorField::make(__('Background Color'), $attribute)
                                         ->sketch()
                                         ->default('rgba(0, 0, 0, 0.8)');
                    },
                    'position' => static function (string $attribute) {
                        return Select::make(__('Position'), $attribute)
                                     ->default('average')
                                     ->help('The mode for positioning the tooltip.')
                                     ->options([
                                         'average' => __('Average'),
                                         'nearest' => __('Nearest')
                                     ]);
                    },
                ],
            ]),
            new WidgetOptionTab('Scales', [
                'scales' => [
                    'xAxes' => [
                        $this->getAxesOptions()
                    ],
                    'yAxes' => [
                        $this->getAxesOptions()
                    ]
                ]
            ]),
        ];
    }

    private function getAxesOptions(): array
    {
        return [
            'display' => static function (string $attribute) {
                return Boolean::make(__('Display'), $attribute)->default(true);
            },
            'position' => static function (string $attribute) {
                return Select::make(__('Position'), $attribute)
                             ->options([
                                 'top' => __('Top'),
                                 'left' => __('Left'),
                                 'right' => __('Right'),
                                 'bottom' => __('Bottom'),
                             ])
                             ->help('Position of the axis in the chart.');
            },
            'offset' => static function (string $attribute) {
                return Boolean::make(__('Offset'), $attribute)
                              ->help('If true, extra space is added to the both edges and the axis is scaled to fit into the chart area. This is set to true for a bar chart by default.');
            },
            /**
             * https://www.chartjs.org/docs/latest/axes/styling.html#grid-line-configuration
             */
            'gridLines' => [
                'display' => static function (string $attribute) {
                    return Boolean::make(__('Display'), $attribute)
                                  ->default(true)
                                  ->help('If false, do not display grid lines for this axis.');
                },
                'circular' => static function (string $attribute) {
                    return Boolean::make(__('Circular'), $attribute)
                                  ->help('If true, gridlines are circular (on radar chart only).');
                },
            ]
        ];
    }

    public function component(): string
    {
        return 'bar-chart-widget';
    }
}
