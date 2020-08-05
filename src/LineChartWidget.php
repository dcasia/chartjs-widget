<?php

namespace DigitalCreative\ChartJsWidget;

use DigitalCreative\NovaDashboard\Widget;
use DigitalCreative\NovaDashboard\WidgetOptionTab;
use Illuminate\Support\Str;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\BooleanGroup;
use Laravel\Nova\Fields\Heading;
use Laravel\Nova\Fields\KeyValue;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Timothyasp\Color\Color as ColorField;

abstract class LineChartWidget extends Widget
{

    public function widgetFields()
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
                                           'top' => 50,
                                           'left' => 30,
                                           'right' => 30,
                                           'bottom' => 10,
                                       ]);
                    },
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
                                     ->default('bottom')
                                     ->options([
                                         'top' => __('Top'),
                                         'left' => __('Left'),
                                         'right' => __('Right'),
                                         'bottom' => __('Bottom'),
                                     ]);
                    },
                    'align' => static function (string $attribute) {
                        return Select::make(__('Align'), $attribute)
                                     ->default(fn() => 'center')
                                     ->options([
                                         'start' => __('Start'),
                                         'center' => __('Center'),
                                         'end' => __('End'),
                                     ]);
                    },
                    'labels' => [
                        'boxWidth' => static function (string $attribute) {
                            return Number::make(__('Box Width'), $attribute)->default(8)->help('Width of coloured box.');
                        },
                        'boxHeight' => static function (string $attribute) {
                            return Number::make(__('Box Height'), $attribute)->default(8)->help('Width of coloured box.');
                        },
                        'padding' => static function (string $attribute) {
                            return Number::make(__('Padding'), $attribute)->default(10)->help('Padding between rows of colored boxes.');
                        },
                        'fontColor' => static function (string $attribute) {
                            return ColorField::make(__('Font Color'), $attribute)->sketch();
                        },
                        'fontSize' => static function (string $attribute) {
                            return Number::make(__('Font Size'), $attribute)->default(12)->help('Width of coloured box.');
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
                                         'nearest' => __('Nearest'),
                                     ]);
                    },
                ],
            ]),
            new WidgetOptionTab('Scales', [
                'scales' => [
                    'xAxes' => [
                        $this->getAxesOptions([
                            'position' => static function (string $attribute) {
                                return Select::make(__('Position'), $attribute)
                                             ->default('bottom')
                                             ->options([
                                                 'top' => __('Top'),
                                                 'bottom' => __('Bottom'),
                                             ])
                                             ->help('Position of the axis in the chart.');
                            },
                        ]),
                    ],
                    'yAxes' => [
                        $this->getAxesOptions([
                            'display' => static function (string $attribute) {
                                return Boolean::make(__('Display'), $attribute)->default(false);
                            },
                            'position' => static function (string $attribute) {
                                return Select::make(__('Position'), $attribute)
                                             ->default('left')
                                             ->options([
                                                 'left' => __('Left'),
                                                 'right' => __('Right'),
                                             ])
                                             ->help('Position of the axis in the chart.');
                            },
                        ]),
                    ],
                ],
            ]),
        ];
    }

    private function getAxesOptions(array $extra = []): array
    {
        return array_merge([
            'display' => static function (string $attribute) {
                return Boolean::make(__('Display'), $attribute)->default(true);
            },
            /**
             * https://www.chartjs.org/docs/latest/axes/styling.html#grid-line-configuration
             */
            'ticks' => [
                'padding' => static function (string $attribute) {
                    return Number::make(__('Padding'), $attribute)->default(0)->help('Padding between the tick label and the axis. When set on a vertical axis, this applies in the horizontal (X) direction. When set on a horizontal axis, this applies in the vertical (Y) direction.');
                },
            ],
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
            ],
        ], $extra);
    }

    public function component(): string
    {
        return 'line-chart-widget';
    }

    public function settings(): array
    {
        return [

            Text::make(__('Title'), static::TITLE)->default(static function () {
                return Str::title(Str::snake(class_basename(static::class), ' '));
            }),

            Text::make(__('Color Scheme'), static::COLOR_SCHEME)
                ->default('tableau.Classic10')
                ->rules([ 'startsWith:brewer.,office.,tableau.', 'nullable' ])
                ->help(__('See: :link for available options.', [ 'link' => '<a target="_blank" href="https://nagix.github.io/chartjs-plugin-colorschemes/colorchart.html">#color-schema</a>' ])),

            KeyValue::make(__('Padding'), static::PADDING)
                    ->disableEditingKeys()
                    ->disableDeletingRows()
                    ->disableAddingRows()
                    ->default([
                        static::PADDING_TOP => 40,
                        static::PADDING_LEFT => 0,
                        static::PADDING_RIGHT => 0,
                        static::PADDING_BOTTOM => 0,
                    ]),

            Heading::make(__('Tooltip')),

            BooleanGroup::make(__('Settings'), static::TOOLTIP_SETTINGS)
                        ->options([
                            static::TOOLTIP_SHOW => __('Show'),
                            static::TOOLTIP_INTERSECT => __('Intersect'),
                            static::TOOLTIP_SHOW_COLORS => __('Show Colors'),
                        ])
                        ->default([
                            static::TOOLTIP_SHOW => true,
                            static::TOOLTIP_INTERSECT => true,
                            static::TOOLTIP_SHOW_COLORS => false,
                        ]),

            KeyValue::make(__('Settings'), static::TOOLTIPS)
                    ->default([
                        'intersect' => true,
                    ])
                    ->help(__('See: :link for available options.', [ 'link' => '<a target="_blank" href="https://www.chartjs.org/docs/latest/configuration/tooltip.html#tooltip-configuration">#tooltip-configuration</a>' ])),

            Heading::make(__('Legend')),

            Boolean::make(__('Show'), static::SHOW_LEGEND)->default(true),

            Select::make(__('Positioning'), static::LEGEND_POSITIONING)
                  ->default(static::LEGEND_POSITIONING_BOTTOM)
                  ->options([
                      static::LEGEND_POSITIONING_TOP => __('Top'),
                      static::LEGEND_POSITIONING_LEFT => __('Left'),
                      static::LEGEND_POSITIONING_BOTTOM => __('Bottom'),
                      static::LEGEND_POSITIONING_RIGHT => __('Right'),
                  ]),

            Select::make(__('Alignment'), static::LEGEND_ALIGNMENT)
                  ->default(static::LEGEND_ALIGNMENT_START)
                  ->options([
                      static::LEGEND_ALIGNMENT_START => __('Start'),
                      static::LEGEND_ALIGNMENT_CENTER => __('Center'),
                      static::LEGEND_ALIGNMENT_END => __('End'),
                  ]),

            Heading::make(__('Horizontal Axis (xAxes)')),

            BooleanGroup::make(__('Settings'), static::HORIZONTAL_AXIS)
                        ->options([
                            static::AXIS_DISPLAY => __('Display Axis'),
                            static::AXIS_SHOW_GRID_LINES => __('Display Grid Lines'),
                            static::AXIS_SHOW_GRID_LINES_BORDER => __('Display Grid Lines Border'),
                        ]),

            Number::make(__('Tick Padding'), static::HORIZONTAL_AXIS_TICK_PADDING)->default(0),
            Number::make(__('Tick Line Height'), static::HORIZONTAL_AXIS_TICK_LINE_HEIGHT)->default(1),

            Heading::make(__('Vertical Axis (yAxes)')),

            BooleanGroup::make(__('Settings'), static::VERTICAL_AXIS)
                        ->options([
                            static::AXIS_DISPLAY => __('Display Axis'),
                            static::AXIS_SHOW_GRID_LINES => __('Display Grid Lines'),
                            static::AXIS_SHOW_GRID_LINES_BORDER => __('Display Grid Lines Border'),
                        ]),

            Number::make(__('Tick Padding'), static::VERTICAL_AXIS_TICK_PADDING)->default(0),
            Number::make(__('Tick Line Height'), static::VERTICAL_AXIS_TICK_LINE_HEIGHT)->default(1),

        ];
    }

    /**
     * See link bellow for all possible values that can be given to this function
     *
     * @link https://nagix.github.io/chartjs-plugin-colorschemes/colorchart.html
     *
     * @param string $colorScheme
     *
     * @return $this
     */
    public function colorScheme(string $colorScheme): self
    {
        return $this->withMeta([ 'colorScheme' => $colorScheme ]);
    }

    public function value(): ValueResult
    {
        return new ValueResult();
    }

}
